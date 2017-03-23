# 3) Newsletter Renderer

I've created module Renderer, which can render block with divs, images, button, inputs, e.t.c. It rendering recursively. So it supports unlimited amount of nested sets, so div can be in div of div e.t.c.

For tests I used Mocha and Chai. So, first we need to install them via NPM:

``` bash
npm install mocha chai --save-dev
```

I've added several tests in HTML to show in browsers. So, you can just run "test_in_browser.html" file locally.

If you need, I can create more tests.