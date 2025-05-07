<?php

use Modules\PageViews\Models\PageView;
use Modules\PageViews\ValueObjects\UserAgent;

it("has_user_agent_value_object", function () {
    $user_agent = UserAgent::fromUserAgent(
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/237.84.2.178 Safari/537.36"
    );

    expect($user_agent)->toBeInstanceOf(UserAgent::class);

    expect($user_agent->browser)->toBe("Chrome");
    expect($user_agent->browserVersion)->toBe("237.84.2.178");
    expect($user_agent->platform)->toBe("Windows");
    expect($user_agent->platformVersion)->toBe("10.0");
    expect($user_agent->deviceType)->toBe("desktop");
    expect($user_agent->os)->toBe("Windows");
    expect($user_agent->device)->toBe("WebKit");
    expect($user_agent->isMobile)->toBe(false);
    expect($user_agent->isBot)->toBe(false);
    expect($user_agent->languages)->toBe([]);
});

it("has_user_agent_data", function () {
    $pageView = PageView::factory()
        ->category()
        ->user()
        ->create([
            "agent" => UserAgent::fromUserAgent(
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/237.84.2.178 Safari/537.36"
            ),
        ]);

    expect($pageView->agent)->toBeInstanceOf(UserAgent::class);
    expect($pageView->agent->browser)->toBe("Chrome");
    expect($pageView->agent->browserVersion)->toBe("237.84.2.178");
});
