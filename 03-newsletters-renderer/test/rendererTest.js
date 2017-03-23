describe("Renderer Module", function() {
    describe("Rendering blocks", function() {
        it("renders image", function() {
            // result
            var json = '[{"type":"image","styles":{"cssClass":"123"},"src":""}]';
            var result = rendererModule.getDOM(json);

            // expected
            var div = document.createElement('div');
            var img = document.createElement('img');
            img.className = '123';
            div.appendChild(img);

            assert.equal(result.outerHTML,div.outerHTML);
        });

        it("renders DIV", function() {
            // result
            var json = '[{"type":"div","styles":{"cssClass":"div"}}]';
            var result = rendererModule.getDOM(json);

            // expected
            var div1 = document.createElement('div');
            var div2 = document.createElement('div');
            div2.className = 'div';
            div1.appendChild(div2);

            assert.equal(result.outerHTML,div1.outerHTML);
        });

        it("renders button", function() {
            // result
            var json = '[{"type":"button","value":"Test","styles":{"cssClass":"btn"}}]';
            var result = rendererModule.getDOM(json);

            // expected
            var div = document.createElement('div');
            var obj = document.createElement('button');
            obj.innerHTML = 'Test';
            obj.className = 'btn';
            div.appendChild(obj);

            assert.equal(result.outerHTML,div.outerHTML);
        });

        it("renders recursive nesting", function() {
            // result
            var json = '[{"type":"div","styles":{"cssClass":""},"blocks":[{"type":"div","styles":{"cssClass":""},"blocks":[{"type":"text","text":"Test","styles":{"cssClass":""}}]}]}]';
            var result = rendererModule.getDOM(json);

            // expected
            var div1 = document.createElement('div');

            var div2 = document.createElement('div');
            div2.className = '';
            div1.appendChild(div2);

            var div3 = document.createElement('div');
            div3.className = '';
            div2.appendChild(div3);

            var p = document.createElement('p');
            p.className = '';
            p.innerText = 'Test';
            div3.appendChild(p);

            assert.equal(result.outerHTML,div1.outerHTML);
        });
    });
});