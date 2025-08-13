<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class MassUpdateRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;
    protected array $ids;
    protected string $field;
    protected mixed $value;

    public function __construct(string $modelClass, array $ids, string $field, mixed $value)
    {
        $this->modelClass = $modelClass;
        $this->ids = $ids;
        $this->field = $field;
        $this->value = $value;
    }

    public function handle(): void
    {
        /** @var Model $model */
        $model = new $this->modelClass;
        $model->whereIn('id', $this->ids)
              ->update([$this->field => $this->value]);
    }
}
