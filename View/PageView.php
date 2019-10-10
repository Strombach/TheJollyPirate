<?php

namespace View;

class PageView
{

  public function render($v)
  {
    echo '<!DOCTYPE html
      <html>
        <head>
          <meta charset="utf-8">
          <title>The Jolly Pirate</title>
        </head>
        <body>
          <h1>The Jolly Pirate</h1>
          <a href="?compact">Compact List</a>
          <br>
          <a href="?verbose">Verbose List</a>
          <div class="container">
            ' . $this->viewToRender($v) . '
          </div>
          <footer>
            <h3>Created By</h3>
          </footer>
        </body>
      </html>
    ';
  }

  private function viewToRender ($v) {
    if ($v instanceof \View\ListView) {
      return $v->response();
    } else if ($v instanceof \View\MemberView) {
      return $v->response((int) $_GET["member"]);
    }
  }
}
