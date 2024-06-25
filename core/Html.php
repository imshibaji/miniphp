<?php
namespace Shibaji\Core;

class Html
{
    private string $title;
    private String $head;
    private String $element;
    private String $style;
    private String $script;
    public function __construct($title='My Demo Website') {
        $this->title = $title;
        $this->head = '';
        $this->element = '';
        $this->style = '';
        $this->script = '';
    }

    public function addTitle($title) {
        $this->title = $title;
    }

    public function meta($name, $content) {
        $this->addHead("<meta name='$name' content='$content'>");
    }

    public function cssLink($href) {
        $this->addStyle("<link rel='stylesheet' href='$href'>");
    }

    public function jsLink($href) {
        $this->addScript("<script src='$href'></script>");
    }

    public function jsCode($code) {
        $this->addScript("<script>$code</script>");
    }

    public function style($value) {
        $this->addStyle("<style>$value</style>");
    }

    public function css($el, $style) {
        $this->addStyle("<style>$el{{$style}}</style>");
    }

    public function js($script) {
        $this->addScript("<script>$script</script>");
    }

    public function tag($el, $content, array $attr= []) {
        if(!isset($attr['style'])) {
            $attr['style'] = "margin: 0px; padding: 0px;";
        }else{
            $attr['style'] .= "margin: 0px; padding: 0px;" . $attr['style'];
        }
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $this->addElement("<$el " . implode(' ', $attr) . " >$content</$el>");
    }

    public function ul(callable $callback, array $attr= []) {
        $this->element('ul', $callback, $attr);
    }

    public function ol(callable $callback, array $attr= []) {
        $this->element('ol', $callback, $attr);
    }

    public function li(callable $callback, array $attr= []) {
        $this->element('li', $callback, $attr);
    }

    public function element($el, callable $callback, array $attr= []) {
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $this->addElement("<$el " . implode(' ', $attr) . " >");
        $this->addElement($callback($this));
        $this->addElement("</$el>");
    }

    public function container(callable $callback, array $attr= []) {
        error_reporting(0);
        if(!isset($attr['style'])) {
            $attr['style'] .= "padding: 10px; display: flex; justify-content: start;";
        }else{
            $attr['style'] .= "padding: 10px; display: flex; justify-content: start;" . $attr['style'];
        }
        $this->element('div', $callback, $attr);
    }
    public function column(callable $callback, array $attr= []) {
        if(!isset($attr['style'])) {
            $attr['style'] .= "display: flex; flex-direction: column;";
        }else{
            $attr['style'] .= "display: flex; flex-direction: column;" . $attr['style'];
        }
        $this->element('div', $callback, $attr);
    }

    public function row(callable $callback, array $attr= []) {
        if(!isset($attr['style'])) {
            $attr['style'] .= "display: flex; flex-direction: row;";
        }else{
            $attr['style'] .= "display: flex; flex-direction: row;" . $attr['style'];
        }
        $this->element('div', $callback, $attr);
    }

    public function table(callable $callback, array $attr= []) {
        $headers = isset($attr['headers']) ? $attr['headers'] : [];
        unset($attr['headers']);
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $this->addElement("<table " . implode(' ', $attr) . " >");
        if(count($headers) > 0) {
            $this->addElement("<thead>");
            $this->addElement("<tr>");
            foreach ($headers as $header) {
                $this->addElement("<th>$header</th>");
            }
            $this->addElement("</tr>");
            $this->addElement("</thead>");
        }
        $this->addElement($callback($this));
        $this->addElement("</table>");
    }

    public function tr(callable $callback, array $attr= []) {
        $this->element('tr', $callback, $attr);
    }

    public function td($value, array $attr= []) {
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $this->addElement("<td " . implode(' ', $attr) . " >$value</td>");
    }

    public function form($action, $method, callable $callback, array $attr= []) {
        $attr['action'] = $action;
        $attr['method'] = $method;
        $this->element('form', $callback, $attr);
    }

    public function input($type, $name, array $attr= []) {
        $elName = strtolower($name);
        $elName = str_replace(' ', '_', $elName);
        $attr['id'] = $elName;
        $attr['name'] = $elName;
        $attr['type'] = $type;
        $lavel = isset($attr['label']) ? "<span>".$attr['label']."</span>" : '';
        $name = isset($attr['label']) ? '' : "<span>".$name."</span> ";
        $for = isset($attr['label']) ? '' : 'for="'.$elName.'"';
        unset($attr['label']);
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $attr = implode(' ', $attr);
        $this->addElement("<label $for>$name");
        $this->addElement("<input " . $attr . " />");
        $this->addElement($lavel);
        $this->addElement("</label> ");
    }

    public function text($name, array $attr= []) {
        if(!isset($attr['placeholder'])) {
            $attr['placeholder'] = $name;
        }
        $this->input('text', $name, $attr);
    }
    public function textarea($value, $name, array $attr= []) {
        $this->addElement("<textarea name='$name' " . implode(' ', $attr) . " >$value</textarea>");
    }
    public function button($value, $type='button', array $attr= []) {
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $attr = implode(' ', $attr);
        $this->addElement("<button type='$type' " . $attr . " >$value</button>");
    }

    public function checkbox($name, $value, array $attr= []) {
        $attr['value'] = $value;
        $this->input('checkbox', $name, $attr);
    }

    public function radio($name, $value, array $attr= []) {
        $attr['value'] = $value;
        $this->input('radio', $name, $attr);
    }

    public function hidden($name, $value, array $attr= []) {
        $attr['value'] = $value;
        foreach ($attr as $k => $v) {
            $attr[$k] = $k.'="'.$v.'"';
        }
        $this->addElement("<input type='hidden' name='$name' value='$value' " . implode(' ', $attr) . " />");
    }

    public function password($name, $value, array $attr= []) {
        $this->addElement("<input type='password' name='$name' value='$value' " . implode(' ', $attr) . " />");
    }

    public function select($name, $callback, array $attr= []) {
        $this->addElement("<select name='$name' " . implode(' ', $attr) . " >");
        $this->addElement($callback($this));
        $this->addElement("</select>");
    }

    public function option($name, $value, array $attr= []) {
        $this->addElement("<option name='$name' " . implode(' ', $attr) . " >$value</option>");
    }


    public function startForm($action, $method, array $attr= []) {
        $this->addElement("<form action='$action' method='$method' " . implode(' ', $attr) . " >");
    }
    public function endForm() {
        $this->addElement("</form>");
    }

    public function submit($value, $name='', array $attr= []) {
        $this->addElement("<input type='submit' name='$name' value='$value' " . implode(' ', $attr) . " />");
    }

    public function reset($value, $name, array $attr= []) {
        $this->addElement("<input type='reset' name='$name' value='$value' " . implode(' ', $attr) . " />");
    }

    

    public function addElement($element) {
        $this->element .= $element;
    }

    public function addStyle($style) {
        $this->style .= $style;
    }

    public function addScript($script) {
        $this->script .= $script;
    }

    public function addHead($head) {
        $this->head .= $head;
    }

    private function run() {
        ob_clean();
        echo <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>$this->title</title>
                $this->head
                $this->style
            </head>
            <body>
                $this->element
                $this->script
            </body>
            </html>
        HTML;
    }

    public function renderApp()
    {
        $this->run();
    }
}