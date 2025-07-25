<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Mail\RegisterCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class RegisterCodeMailTest extends TestCase
{
    public function test_build_contains_expected_view_and_data()
    {
        $code = '123456';
        $mail = new RegisterCodeMail($code);

        $built = $mail->build();

        $this->assertInstanceOf(Mailable::class, $built);
        $this->assertEquals("Votre code d'inscription", $built->subject);

        $this->assertEquals('mails.register-code', $built->view);
        $this->assertArrayHasKey('code', $built->viewData);
        $this->assertEquals($code, $built->viewData['code']);
    }
}
