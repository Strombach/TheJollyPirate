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
            <ol>
            ' . $v->createList() . '
            </ol>
          </div>
        </body>
      </html>
    ';
  }
}