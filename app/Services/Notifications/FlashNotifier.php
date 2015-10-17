<?php

namespace Gistvote\Services\Notifications;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

class FlashNotifier
{
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Sets a successful flash message.
     *
     * @param $message
     */
    public function success($message)
    {
        $this->message($message, 'success');
    }

    /**
     * Sets an error flash message.
     *
     * @param $message
     */
    public function error($message)
    {
        $this->message($message, 'danger');
    }

    /**
     * Sets a validation error flash message.
     *
     * @param MessageBag $errors
     * @param string $message
     */
    public function validation(MessageBag $errors, $message = 'Form validation failed')
    {
        $this->error($message);
        $this->session->flash('flash_notification.validation', $errors->getMessages());
    }

    /**
     * Sets a flash message.
     *
     * @param $message
     * @param string $level
     */
    public function message($message, $level = 'info')
    {
        $this->session->flash('flash_notification.message', $message);
        $this->session->flash('flash_notification.level', $level);
    }
}
