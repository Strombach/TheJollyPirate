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
          <a href="?verbose">Verbose List</a>
          <a href="?compact">Compact List</a>
          <div class="container">
            <p>This is the beginning</p>
            ' . $v->response() . '
            <h2>List:</h2>
            ' . $this->wantVerbose($v) . '
            <ol>
            </ol>
          </div>
          <footer>
            <h3>Created By</h3>
            <p>Dennis Fredsson (df222fx)</p>
            <p>Fredrik Strömbäck (fs222uv)</p>
            <p>Markus Öhlen (mo223dg)</p>
          </footer>
        </body>
      </html>
    ';
  }

  public function wantVerbose($v)
  {
    if (!isset($_GET["verbose"])) {
      return $v->createCompactList();
    } else {
      return $v->createVerboseList();
    }
  }
}
