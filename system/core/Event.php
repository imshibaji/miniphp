<?php
namespace Shibaji\Core;

class Event
{
    private $eventId;
    private $eventName;
    private $eventDate;
    private $attendees = [];

    /**
     * Constructor to initialize the event with name and date.
     *
     * @param string $eventName The name of the event.
     * @param string $eventDate The date of the event (YYYY-MM-DD format).
     */
    public function __construct($eventName, $eventDate)
    {
        $this->eventId = uniqid('event_');
        $this->eventName = $eventName;
        $this->eventDate = $eventDate;
    }

    /**
     * Adds an attendee to the event.
     *
     * @param string $attendeeName The name of the attendee.
     * @param string $email The email of the attendee.
     * @param string|null $ticketType Optional. The type of ticket or role of the attendee.
     */
    public function addAttendee($attendeeName, $email, $ticketType = null)
    {
        $this->attendees[] = [
            'name' => $attendeeName,
            'email' => $email,
            'ticket_type' => $ticketType,
        ];
    }

    /**
     * Removes an attendee from the event.
     *
     * @param int $index The index of the attendee in the attendees array.
     */
    public function removeAttendee($index)
    {
        if (isset($this->attendees[$index])) {
            unset($this->attendees[$index]);
            $this->attendees = array_values($this->attendees); // Re-index array after removal
        }
    }

    /**
     * Retrieves details of all attendees in the event.
     *
     * @return array An array of attendees in the event.
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * Retrieves the name of the event.
     *
     * @return string The name of the event.
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * Retrieves the date of the event.
     *
     * @return string The date of the event (YYYY-MM-DD format).
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Retrieves the unique identifier of the event.
     *
     * @return string The event ID.
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Sends email notifications to all attendees.
     *
     * @param string $subject The subject of the email.
     * @param string $message The message content of the email.
     * @return bool Returns true on successful sending, false otherwise.
     */
    public function sendEmailNotifications($subject, $message)
    {
        $success = true;
        
        foreach ($this->attendees as $attendee) {
            $to = $attendee['email'];
            $name = $attendee['name'];
            // Here, implement your email sending logic using a library like PHPMailer or your own SMTP setup
            // Example using PHPMailer:
            /*
            $mail = new PHPMailer();
            $mail->setFrom('your@example.com', 'Your Name');
            $mail->addAddress($to, $name);
            $mail->Subject = $subject;
            $mail->Body = $message;
            if (!$mail->send()) {
                $success = false;
            }
            */
            // For demonstration purposes, assume success
            // Replace this with your actual email sending logic
            echo "Email sent to $name ($to): $subject - $message<br>";
        }

        return $success;
    }

    /**
     * Sends SMS notifications to all attendees.
     *
     * @param string $message The SMS message content.
     * @return bool Returns true on successful sending, false otherwise.
     */
    public function sendSMSNotifications($message)
    {
        $success = true;

        foreach ($this->attendees as $attendee) {
            $phone = $attendee['phone']; // Assuming 'phone' is a field for phone number in attendees array
            // Here, implement your SMS sending logic using an SMS gateway or API
            // Example using Twilio:
            /*
            $twilio = new Twilio\Rest\Client($accountSid, $authToken);
            $twilio->messages->create(
                $phone,
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );
            */
            // For demonstration purposes, assume success
            // Replace this with your actual SMS sending logic
            echo "SMS sent to $phone: $message<br>";
        }

        return $success;
    }
}