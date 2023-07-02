<?php

namespace Desuex\TesttaskNotification;

interface UserEmailSenderInterface
{
    public function sendEmailChangedNotification(string $oldEmail, string $newEmail): void;
}
