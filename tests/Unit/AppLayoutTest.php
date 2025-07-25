<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\View\Components\AppLayout;

class AppLayoutTest extends TestCase
{
    public function test_render_returns_expected_view()
    {
        $layout = new AppLayout();
        $view = $layout->render();

        $this->assertEquals('layouts.app', $view->name());
    }
}
