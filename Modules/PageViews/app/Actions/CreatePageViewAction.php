<?php

namespace Modules\PageViews\Actions;

use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Guests\Models\Guest;
use Modules\PageViews\Enums\ViewableType;
use Modules\PageViews\Models\PageView;
use Modules\PageViews\ValueObjects\UserAgent;
use Modules\Products\Models\Product;
use Modules\Tags\Models\Tag;
use Modules\Users\Models\User;
use Symfony\Component\HttpFoundation\Response;

final class CreatePageViewAction
{
    use HasActionHelpers;

    public function handle(
        ViewableType $viewableType,
        string $viewableSlug,
        string $userAgent,
        array $headers = [],
        User|Guest $viewerable,
        ?string $ipAddress = null,
        ?string $page = null
    ) {
        $viewable = match ($viewableType->value) {
            "product" => Product::firstWhere("slug", "=", $viewableSlug),
            "category" => Category::firstWhere("slug", "=", $viewableSlug),
            "brand" => Brand::firstWhere("slug", "=", $viewableSlug),
            "tag" => Tag::firstWhere("slug", "=", $viewableSlug),
        };

        if (!$viewable) {
            throw new ApiException(
                "Viewable not found",
                Response::HTTP_NOT_FOUND
            );
        }

        return PageView::create([
            "viewable_id" => $viewable->id,
            "viewable_type" => get_class($viewable),
            "viewerable_id" => $viewerable?->id,
            "viewerable_type" => get_class($viewerable),
            "agent" => UserAgent::fromUserAgent($userAgent, $headers),
            "ip_address" => $ipAddress,
            "page" => $page,
        ]);
    }
}
