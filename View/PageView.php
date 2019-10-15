<?php

namespace View;

class PageView
{

  public function render($view)
  {
    echo '<!DOCTYPE html
      <html>
        <head>
          <meta charset="utf-8">
          <title>The Jolly Pirate</title>
          <link rel="stylesheet" type="text/css" href="../style.css">
        </head>
        <body>
          <h1>The Jolly Pirate</h1>
          <div class="container">
            ' . $this->viewToRender($view) . '
          </div>
          <footer>
            <h3>Created By</h3>
            <p>Dennis Fredsson • Fredrik Strömbäck • Markus Öhlén</p>
          </footer>
        </body>
      </html>
    ';
  }


  private function viewToRender($view)
  {
    if ($view instanceof \View\ListView) {
      return $view->response();
    } else if ($view instanceof \View\MemberView) {
      return $view->response((int) $_GET["member"]);
    } else if ($view instanceof \View\EditMemberView) {
      return $view->response((int) $_GET["editmember"]);
    } else if ($view instanceof \View\EditBoatView) {
      return $view->response($_GET["editboat"]);
    }
  }
}
