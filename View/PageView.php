<?php

namespace View;

class PageView
{
  private $errorMessage = '';
  private $view;


  public function render($view)
  {
    $this->view = $view;
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
            ' . $this->errorMessage . '
          </div>
          <footer>
            <h3>Created By</h3>
            <p>Dennis Fredsson • Fredrik Strömbäck • Markus Öhlén</p>
          </footer>
        </body>
      </html>
    ';
  }

  public function setErrorMessage (string $errorMessage) {
    $this->errorMessage = $errorMessage;
    $this->render($this->view);
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
