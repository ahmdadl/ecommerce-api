<?php

namespace Modules\ContactUs\Filament\Resources;

use Illuminate\Support\Str;
use Modules\ContactUs\Filament\Resources\ContactUsMessageResource\Pages;
use Modules\ContactUs\Filament\Resources\ContactUsMessageResource\RelationManagers;
use Modules\ContactUs\Models\ContactUsMessage;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components as I;
use Filament\Tables\Columns as C;
use Filament\Tables\Filters as F;
use Filament\Tables\Actions as A;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Infolists;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Enums\FiltersLayout;

class ContactUsMessageResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = ContactUsMessage::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getPermissionPrefixes(): array
    {
        return ["view", "reply", "delete", "restore"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make("Message Details")
                ->schema([
                    Infolists\Components\TextEntry::make("name")->label("Name"),
                    Infolists\Components\TextEntry::make("email")->label(
                        "Email"
                    ),
                    Infolists\Components\TextEntry::make("phone")
                        ->label("Phone")
                        ->default("-"),
                    Infolists\Components\TextEntry::make("order_id")
                        ->label("Order ID")
                        ->default("-"),
                    Infolists\Components\TextEntry::make("subject")->label(
                        "Subject"
                    ),
                    Infolists\Components\TextEntry::make("message")
                        ->label("Message")
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Infolists\Components\Section::make("Status")
                ->schema([
                    Infolists\Components\IconEntry::make("is_seen")
                        ->label("Seen")
                        ->boolean(),
                    Infolists\Components\IconEntry::make("is_replied")
                        ->label("Replied")
                        ->boolean()
                        ->getStateUsing(
                            fn($record): bool => !is_null($record->replied_at)
                        ),
                    Infolists\Components\TextEntry::make("replied_at")
                        ->label("Replied At")
                        ->dateTime(),
                    Infolists\Components\TextEntry::make("reply")
                        ->label("Reply")
                        ->default("-")
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                C\TextColumn::make("name")
                    ->translateLabel()
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        $initials = collect(explode(" ", $record->name))
                            ->map(
                                fn($word) => strtoupper(
                                    substr(trim($word), 0, 1)
                                )
                            )
                            ->take(2)
                            ->implode("");

                        return view("contactus::filament.columns.profile", [
                            "initials" => $initials,
                            "name" => $record->name,
                            "email" => $record->email,
                        ])->render();
                    })
                    ->html(),
                C\TextColumn::make("id")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("email")
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                C\TextColumn::make("subject")
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                C\IconColumn::make("is_seen")
                    ->boolean()
                    ->translateLabel()
                    ->toggleable(),
                C\IconColumn::make("is_replied")
                    ->boolean()
                    ->translateLabel()
                    ->toggleable()
                    ->getStateUsing(function ($record): bool {
                        return !is_null($record->replied_at);
                    }),
                C\TextColumn::make("message")
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("created_at")
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("replied_at")
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                //
            ])
            ->filters(
                [
                    F\TernaryFilter::make("is_seen")->translateLabel(),

                    F\TernaryFilter::make("is_replied")
                        ->translateLabel()
                        ->queries(
                            true: fn($query) => $query->whereNotNull(
                                "replied_at"
                            ),
                            false: fn($query) => $query->whereNull("replied_at")
                        ),

                    F\Filter::make("created_at")
                        ->form([
                            I\DatePicker::make(
                                "created_from"
                            )->translateLabel(),
                            I\DatePicker::make(
                                "created_until"
                            )->translateLabel(),
                        ])
                        ->query(function ($query, array $data) {
                            if ($data["created_from"]) {
                                $query->whereDate(
                                    "created_at",
                                    ">=",
                                    $data["created_from"]
                                );
                            }
                            if ($data["created_until"]) {
                                $query->whereDate(
                                    "created_at",
                                    "<=",
                                    $data["created_until"]
                                );
                            }
                        })
                        ->columns(2)
                        ->indicateUsing(function (array $data): ?string {
                            $indicators = [];
                            if ($data["created_from"]) {
                                $indicators[] = "Created From: {$data["created_from"]}";
                            }
                            if ($data["created_until"]) {
                                $indicators[] = "Created Until: {$data["created_until"]}";
                            }
                            return !empty($indicators)
                                ? implode(", ", $indicators)
                                : null;
                        }),

                    F\Filter::make("replied_at")
                        ->form([
                            I\DatePicker::make(
                                "replied_from"
                            )->translateLabel(),
                            I\DatePicker::make(
                                "replied_until"
                            )->translateLabel(),
                        ])
                        ->query(function ($query, array $data) {
                            if ($data["replied_from"]) {
                                $query->whereDate(
                                    "replied_at",
                                    ">=",
                                    $data["replied_from"]
                                );
                            }
                            if ($data["replied_until"]) {
                                $query->whereDate(
                                    "replied_at",
                                    "<=",
                                    $data["replied_until"]
                                );
                            }
                        })
                        ->columns(2)
                        ->indicateUsing(function (array $data): ?string {
                            $indicators = [];
                            if ($data["replied_from"]) {
                                $indicators[] = "Replied From: {$data["replied_from"]}";
                            }
                            if ($data["replied_until"]) {
                                $indicators[] = "Replied Until: {$data["replied_until"]}";
                            }
                            return !empty($indicators)
                                ? implode(", ", $indicators)
                                : null;
                        }),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                A\ViewAction::make()->iconButton(),
                A\DeleteAction::make()->iconButton(),
                A\RestoreAction::make(),
            ])
            ->bulkActions([
                A\BulkActionGroup::make([A\DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListContactUsMessages::route("/"),
            // "create" => Pages\CreateContactUsMessage::route("/create"),
            "view" => Pages\ViewContactUsMessageForAdmin::route("/{record}"),
        ];
    }
}
