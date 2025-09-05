<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AdminUserActionNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $user;
    public $action;
    public $actionDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(User $admin, User $user, string $action, array $actionDetails = [])
    {
        $this->admin = $admin;
        $this->user = $user;
        $this->action = $action;
        $this->actionDetails = $actionDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $icons = [
            'block' => '🚫',
            'unblock' => '✅',
            'delete' => '🗑️',
            'role_change' => '👤',
            'password_reset' => '🔐',
        ];

        $icon = $icons[$this->action] ?? '📝';
        
        return new Envelope(
            subject: $icon . ' ACTION ADMIN - ' . strtoupper($this->action) . ' - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.admin.user-action-notification', [
                'admin' => $this->admin,
                'user' => $this->user,
                'action' => $this->action,
                'actionDetails' => $this->actionDetails,
            ])->render(),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
