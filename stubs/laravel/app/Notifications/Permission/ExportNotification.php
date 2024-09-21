<?php

namespace App\Notifications\Permission;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionsExports;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportNotification extends Notification
{

    use Queueable;

    private $data;

    private $path;

    public function __construct(array $data)
    {   

        $this->data = $data;

        $this->path = $this->getPath();

    }

    public function via($notifiable)
    {
        
        return config('app.notification_via', ['mail', 'database']);

    }

    public function toMail($notifiable)
    {

        $this->createExport();
        
        return (new MailMessage)
                    ->subject($this->getSubject())
                    ->greeting($this->getWellcomeMessage())
                    ->line($this->getBodyMessage())
                    ->action($this->getActionButton(), $this->getNotificationUrl())
                    ->line($this->getFarewallMessage());

    }

    public function toArray($notifiable)
    {
        
        return [
            'action' => $this->getActionUrl(),
            'message' => $this->getBodyMessage(),
            'img' => $this->getImg(),
        ];

    }

    // CUSTOME METHODS
    
    private function createExport()
    {

        Excel::store(new PermissionsExports($this->data), $this->path, config('app.export_disk', 's3'));

    }

    private function getSubject()
    {

        return env('APP_NAME') . ' | Permission export notification';

    }

    private function getWellcomeMessage()
    {
        
        return 'Hola';

    }

    private function getBodyMessage()
    {
        
        return 'Da clic para descargar el archivo. Después de 24 horas será eliminado.';

    }

    private function getActionButton()
    {

        return 'Descargar';

    }

    private function getNotificationUrl()
    {

        return url('/notification/read/' . $this->id);

    }

    private function getActionUrl()
    {
        
        return config('app.aws_url') . $this->path;

    }

    private function getImg()
    {

        return 'https://www.gravatar.com/avatar';
        
    }

    private function getFarewallMessage()
    {

        return '¡Gracias por utilizar nuestra aplicación!';

    }

    private function getPath()
    {

        return 'exports/' . base64_encode(microtime()) . '.xlsx';

    }

}
