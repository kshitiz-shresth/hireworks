<?php

namespace App\Notifications;
use DateTime;
use App\InterviewSchedule;
use App\JobApplication;
use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidateScheduleInterview extends Notification
{
    use Queueable, SmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobApplication $jobApplication,InterviewSchedule $interviewSchedule, $timezone, $comment)
    {
        $this->jobApplication = $jobApplication;
        $this->interviewSchedule = $interviewSchedule;
        $this->timeZone = $timezone;
        $this->comment = $comment;
        $this->setMailConfigs();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    
    function dateToCal($time) {
    	return date('Ymd\This', strtotime(str_replace('-','/', $time)));
    }
    
    function endDateToCal($time) {
        $endDate = new DateTime($time);
        $endDate->modify("+1 hours");

        return date('Ymd\This', strtotime(str_replace('-','/', $endDate->format('Y/m/d H:i:s'))));
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $filename = "job interview.ics";
        $data[0]  = "BEGIN:VCALENDAR";
        $data[1] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
        $data[2] = "VERSION:2.0";
        $data[3] = "CALSCALE:GREGORIAN";
        $data[4] = "METHOD:REQUEST";
        $data[8] = "BEGIN:VEVENT";
        $data[9] = "DTSTART;TZID=". $this->timeZone .":".self::dateToCal($this->interviewSchedule->schedule_date->format('Y/m/d H:i:s'));
        $data[10] = "DTEND;TZID=". $this->timeZone .":".self::endDateToCal($this->interviewSchedule->schedule_date);
        $data[11] = "DTSTAMP:".self::dateToCal($this->interviewSchedule->schedule_date->format('Y/m/d H:i:s'));
        $data[12] = "UID:hello@hireworks.ai";
        $data[13] = "CREATED:20140312T072126Z";
        $data[14] = "DESCRIPTION:You have been seleted for job interview";
        $data[15] = "SEQUENCE:0";
        $data[16] = "STATUS:CONFIRMED";
        $data[17] = "SUMMARY:Job interview";
        $data[18] = "TRANSP:OPAQUE";
        $data[19] = "END:VEVENT";
        $data[20] = "END:VCALENDAR";

        $data = implode("\r\n", $data);
        header("text/calendar");
        file_put_contents($filename, "\xEF\xBB\xBF".  $data);

//        dd($notifiable);
        return (new MailMessage)
            ->subject(__('email.interviewSchedule.subject'))
            ->greeting(__('email.hello').' ' . ucwords($notifiable->full_name) . '!')
            ->line('You have been seleted for job interview '.' for ' . ucwords($this->jobApplication->job->title))
            ->line(('Interview Date').' - ' . $this->interviewSchedule->schedule_date->format('M d, Y h:i a'). ' (' . $this->timeZone .')' )
            ->line($this->comment)
            ->line(__('email.thankyouNote'))
            ->attach($filename, [
                'mime' => 'text/calendar',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $this->jobApplication->toArray()
        ];
    }

}