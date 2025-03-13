<?php

use Modules\Banners\Models\Banner;

test("banner_have_single_upload_casts", function () {
    $banner = Banner::factory()->create();

    expect($banner->media)->toBeString(uploads_url($banner->media));
});
