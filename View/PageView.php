<?php

namespace View;

class PageView {

  public function render ($v) {
    echo '<!DOCTYPE html
      <html>
        <head>
          <meta charset="utf-8">
          <title>The Jolly Pirate</title>
        </head>
        <body>
          <h1>The Jolly Pirate</h1>
          <div class="container">
            <p>This is the beginning</p>
            ' . $v->response() . '
            <h2>Compact List:</h2>
            <ol>
            ' . $v->createCompactList() . '
            </ol>
            <h2>Verbose List:</h2>
            <ol>
            ' . $v->createVerboseList() . '
            </ol>
          </div>
        </body>
      </html>
    ';
  }
}