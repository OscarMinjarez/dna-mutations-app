<?php

namespace App\Services;

use App\Models\DnaSequence;

class DnaMutationService {

    protected const VALID_LETTERS = ["A", "T", "C", "G"];
    protected const SEQUENCE_LENGTH = 4;

    public function hasMutation(array $dna): DnaSequence {
        $n = count($dna);
        foreach ($dna as $row) {
            if (strlen($row) !== $n || !preg_match('/^[ATCG]+$/', $row)) {
                throw new \InvalidArgumentException(
                    __('errors.dna_invalid_characters')
                );
            }
        }
        $matrix = array_map('str_split', $dna);
        $sequencesFound = 0;
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if (
                    $this->checkDirection($matrix, $i, $j, 0, 1, $n) ||
                    $this->checkDirection($matrix, $i, $j, 1, 0, $n) ||
                    $this->checkDirection($matrix, $i, $j, 1, 1, $n) ||
                    $this->checkDirection($matrix, $i, $j, 1, -1, $n)
                ) {
                    $sequencesFound++;
                    if ($sequencesFound > 1) {
                        return DnaSequence::create([
                            'dna' => $dna,
                            'has_mutation' => true
                        ]);
                    }
                }
            }
        }
        return DnaSequence::create([
            'dna' => $dna,
            'has_mutation' => false
        ]);
    }

    private function checkDirection(array $matrix, int $x, int $y, int $dx, int $dy, int $n): bool {
        if (
            $x + self::SEQUENCE_LENGTH * $dx > $n ||
            $x + self::SEQUENCE_LENGTH * $dx < -1 ||
            $y + self::SEQUENCE_LENGTH * $dy > $n ||
            $y + self::SEQUENCE_LENGTH * $dy < -1
        ) {
            return false;
        }
        $letter = $matrix[$x][$y] ?? null;
        for ($k = 1; $k < self::SEQUENCE_LENGTH; $k++) {
            $nx = $x + $dx * $k;
            $ny = $y + $dy * $k;
            if (!isset($matrix[$nx][$ny]) || $matrix[$nx][$ny] !== $letter) {
                return false;
            }
        }
        return true;
    }


    public function getRecentSequences(?bool $hasMutation = null, int $perPage = 10) {
        $query = DnaSequence::orderBy('_id', 'desc');
        if (!is_null($hasMutation)) {
            $query->where('has_mutation', $hasMutation);
        }
        return $query->paginate($perPage);
    }

    public function getStatsSummary() {
        $result = DnaSequence::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$has_mutation',
                        'count' => ['$sum' => 1],
                    ],
                ],
            ]);
        });
        $count_mutations = 0;
        $count_no_mutation = 0;
        foreach ($result as $doc) {
            if ($doc->_id === true) {
                $count_mutations = $doc->count;
            } elseif ($doc->_id === false) {
                $count_no_mutation = $doc->count;
            }
        }
        $ratio = $count_no_mutation === 0 ? 0 : $count_mutations / $count_no_mutation;
        return [
            'count_mutations' => $count_mutations,
            'count_no_mutation' => $count_no_mutation,
            'ratio' => $ratio,
        ];
    }
}