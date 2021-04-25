<?php
/**
 * Created by PhpStorm.
 * User: 35304
 * Date: 2021/4/25
 * Time: 20:33
 */

namespace App\Service;


use App\Models\HotSearch;

class HotSearchService
{
    public static function addHotSearch($search_word)
    {
        $hotSearch = HotSearch::where('words', $search_word)->first();
        if (!$hotSearch) {
            $hotSearch = new HotSearch();
            $hotSearch->words = $search_word;
            $hotSearch->count = 1;
            $hotSearch->sort = 0;
            $hotSearch->status=1;
            $hotSearch->save();
        } else {
            $hotSearch->increment('count');
        }
    }
}