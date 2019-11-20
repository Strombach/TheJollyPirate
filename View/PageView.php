<?php

namespace View;

/**
 * The main class. Generates the entire HTML string that is echoed to the client.
 */
class PageView
{

  /**
   * This method echoes out the complete html page.
   * 
   * @param {View} $view This is the view that should be rendered in the body of the page.
   */
  public function render($view): void
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


  private function viewToRender($view): string
  {
    if ($view instanceof \View\ListView) {
      return $view->response();
    } else if ($view instanceof \View\MemberView) {
      return $view->response($view->getUserID());
    } else if ($view instanceof \View\EditMemberView) {
      return $view->response($view->getEditMemberID());
    } else if ($view instanceof \View\EditBoatView) {
      return $view->response($_GET["editboat"]);
    }
  }
}
