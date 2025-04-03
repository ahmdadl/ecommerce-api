<?php

namespace Modules\Addresses\Actions;

use Illuminate\Http\Request;
use Modules\Addresses\Models\Address;
use Modules\Addresses\Transformers\AddressResource;
use Modules\Cities\Models\City;
use Modules\Cities\Transformers\CityResource;
use Modules\Core\Traits\HasActionHelpers;
use Modules\Governments\Models\Government;
use Modules\Governments\Transformers\GovernmentResource;

class GetAddressesAction
{
    /**
     * get addresses page response
     * @return array{governments: GovernmentResource[], cities: CityResource[], addresses: AddressResource[]}
     */
    public function handle(Request $request): array
    {
        $response = [];

        if ($request->boolean("withGovernments")) {
            $response["governments"] = GovernmentResource::collection(
                Government::active()->get()
            );
        }

        if ($request->boolean("withCities")) {
            $response["cities"] = CityResource::collection(
                City::active()->get()
            );
        }

        $addresses = Address::with(["government", "city"])
            ->where("user_id", user()?->id)
            ->latest()
            ->get();
        $response["addresses"] = AddressResource::collection($addresses);

        return $response;
    }
}
