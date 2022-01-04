<textarea id="editor-{{$name}}" name="{{$name}}" {{ isset($required) ? 'required' : null }} style="height: 250px;">{{ old($name, isset($value) ? $value : null) }}</textarea>

<script type="text/javascript">
CodeMirror.fromTextArea(document.getElementById('editor-{{$name}}'), {
  mode: 'application/x-httpd-php',
  theme: 'lesser-dark',
  indentUnit: 4,
  indentWithTabs: false,
  tabMode: 'shift',
  enterMode: 'keep',
  electricChars: false,
  lineNumbers: true,
  firstLineNumber: 1,
  gutter: false,
  fixedGutter:false,
  matchBrackets: true
});
</script>