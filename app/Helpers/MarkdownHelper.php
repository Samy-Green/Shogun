<?php

namespace App\Helpers;

use League\CommonMark\CommonMarkConverter;

class MarkdownHelper
{
  public static function convert($markdown)
  {
      $converter = new CommonMarkConverter([
          'html_input' => 'strip', // sécurise le HTML
          'allow_unsafe_links' => false,
      ]);

      return $converter->convert($markdown);
  }
}
