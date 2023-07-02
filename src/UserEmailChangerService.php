<?php

namespace Desuex\TesttaskNotification;

class UserEmailChangerService
{
    private \PDO $db;
    private UserEmailSenderInterface $emailSender;

    public function __construct(\PDO $db, UserEmailSenderInterface $emailSender)
    {
        $this->db = $db;
        $this->emailSender = $emailSender;
    }

    public function changeEmail(int $userId, string $email): void
    {
        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare('SELECT email FROM users WHERE id = :id FOR UPDATE');
            $statement->bindParam(':id', $userId, \PDO::PARAM_INT);
            $statement->execute();
            $userEmail = $statement->fetchColumn();

            $updateStatement = $this->db->prepare('UPDATE users SET email = :email WHERE id = :id');
            $updateStatement->bindParam(':id', $userId, \PDO::PARAM_INT);
            $updateStatement->bindParam(':email', $email);
            $updateStatement->execute();

            // Notify user about email change
            $this->emailSender->sendEmailChangedNotification($userEmail, $email);

            $this->db->commit();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
