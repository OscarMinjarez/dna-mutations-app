<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DnaSequence extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'dna_sequences';

    protected $fillable = ['dna', 'has_mutation'];
}
