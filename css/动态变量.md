```
:root{
  --default-color:#f00;
  --primary-color:var(--default-color);
  --height:20;
  --font:'italic bold 12px/30px'
}
div{
  color:var(--primary-color);
  background-color:var(--bg-color, #00f);
  height:calc(var(--height) * 1px);
  font:var(--font)' arial, sans-serif';
  --width: 100px
}
@media screen and (min-width: 768px) {
  :root {
    --height:  30;
  }
  div{
    height: calc(var(--height) * 2px);
  }
}
```
