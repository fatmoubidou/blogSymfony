<?php
// src/Service/ContentFilter.php
namespace App\Service;

class ContentFilter
{
    const INSULTES = ["sit","commodo"];

    public function getContentFilter($contents)
    {
      foreach (self::INSULTES as $key => $value) {
        $contents = str_replace($value, "#####", $contents);
      }

      return $contents;
    }
}
 ?>
