<?php

namespace SiGeEdu\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;

class ClassInformations extends Model implements TableInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_start', 'date_end', 'cycle', 'subdivision', 'semester', 'year',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_start', 'date_end',
    ];

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['ID', 'Start Date', 'End Date', 'Cycle', 'Subdivision', 'Semester', 'Year'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch ($header){
            case 'ID':
                return $this->id;
            case 'Start Date':
                return $this->date_start->format('d/m/Y');
            case 'End Date':
                return $this->date_end->format('d/m/Y');
            case 'Cycle':
                return $this->cycle;
            case 'Subdivision':
                return $this->subdivision;
            case 'Semester':
                return $this->semester;
            case 'Year':
                return $this->year;
        }
    }
}
