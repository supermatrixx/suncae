BEGIN {
  print "const katex = require(\"katex\");"
  print "console.log(\"<?php\");"
}
{
  printf("console.log(\"$label['%s'] = '\"+katex.renderToString(\"%s\")+\"';\");\n", $1, $2);
}
