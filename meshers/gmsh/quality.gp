set style fill  transparent solid 0.50 noborder
set style function filledcurves y1=0
plot "data" u (($1+0.5)/10):3 with boxes, "data" u (($1+0.5)/10):4 with boxes, "data" u (($1+0.5)/10):2 with boxes
