<?php

class HtmlDoc {

    private function showHtmlStart() {
        echo '<!DOCTYPE html>' . PHP_EOL;
        echo '<html>' . PHP_EOL;
    }

    private function showHeadStart() {
        echo '<head>' . PHP_EOL;
    }

    protected function showHeadContent() {

    }

    private function showHeadEnd() {
        echo '</head>' . PHP_EOL;
    }

    private function showBodyStart() {
        echo '<body class="pagetext">' . PHP_EOL;
    }

    protected function showBodyContent() {

    }

    private function showBodyEnd() {
        echo '</body>' . PHP_EOL;
    }

    private function showHtmlEnd() {
        echo '</html>';
    }

    public function show() {
        $this->showHtmlStart();
        $this->showHeadStart();
        $this->showHeadContent();
        $this->showHeadEnd();
        $this->showBodyStart();
        $this->showBodyContent();
        $this->showBodyEnd();
        $this->showHtmlEnd();
    }
}
?>