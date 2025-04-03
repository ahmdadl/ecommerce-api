<?php

namespace Modules\Core\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModelFilter
{
    /**
     * query builder
     */
    protected Builder $builder;

    public function __construct(protected Request $request)
    {
        //
    }

    /**
     * apply filters
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name) && !is_null($value)) {
                call_user_func_array([$this, $name], [$value]);
            }
        }

        return $this->builder;
    }

    /**
     * get all allowed filters with their cast types
     */
    protected function getAllowedFilters(): array
    {
        return []; // will be overridden by child classes
    }

    /**
     * get filters
     * @return array
     */
    public function filters(): array
    {
        // Define accepted filters and their cast types
        $allowedFilters = [...$this->getAllowedFilters(), "id" => "string"];

        // Get all request parameters
        $requestData = $this->request->all();

        // Filter and cast the request data
        $filteredData = [];
        foreach ($allowedFilters as $key => $type) {
            if (array_key_exists($key, $requestData)) {
                $value = $requestData[$key];
                $filteredData[$key] = $this->castValue($value, $type);
            }
        }

        return $filteredData;
    }

    /**
     * Cast the value to the specified type
     */
    protected function castValue($value, string $type)
    {
        switch ($type) {
            case "int":
                return (int) $value;
            case "float":
                return (float) $value;
            case "boolean":
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case "string":
                return (string) $value;
            case "date":
                return \Carbon\Carbon::parse($value)->toDateString(); // Requires Carbon
            default:
                return $value; // Return as-is if type is unknown
        }
    }

    /**
     * base filter to filter by id
     * @param string $value
     * @return Builder
     */
    protected function id(string $value): Builder
    {
        return $this->builder->where("id", $value);
    }
}
