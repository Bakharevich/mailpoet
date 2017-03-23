/**
 * Name: JSON Renderer
 * Description: Module renders JSON according specific block types
 * Version: 0.5
 * Author: Ilya Bakharevich
 */

var rendererModule = (function() {
    var blocks = {};
    blocks.dom = {};

    /**
     *
     * Image block
     *
     */
    blocks.dom.image = function() {
        this.make = function(params) {
            // create element
            var obj = document.createElement('img');
            if (params.src) obj.src = params.src;

            // add specific styles
            if (typeof params.styles.cssClass !== 'undefined') obj.className = params.styles.cssClass;
            if (typeof params.styles.cssText !== 'undefined') obj.style.cssText = params.styles.cssText;

            return obj;
        }
    };

    /**
     *
     * Div layer block
     *
     */
    blocks.dom.div = function() {
        this.make = function(params) {
            // create element
            var obj = document.createElement('div');

            // add specific styles
            if (typeof params.styles.cssClass !== 'undefined') obj.className = params.styles.cssClass;
            if (typeof params.styles.cssText !== 'undefined') obj.style.cssText = params.styles.cssText;

            return obj;
        }
    };

    /**
     *
     * Header text block
     *
     */
    blocks.dom.header = function() {
        this.make = function(params) {
            // create element
            var obj = document.createElement('H1');
            if (typeof params.text !== 'undefined') obj.innerHTML = params.text;

            // add specific styles
            if (typeof params.styles.cssClass !== 'undefined') obj.className = params.styles.cssClass;
            if (typeof params.styles.cssText !== 'undefined') obj.style.cssText = params.styles.cssText;

            return obj;
        }
    };

    /**
     *
     * Text block
     *
     */
    blocks.dom.text = function() {
        this.make = function(params) {
            // create element
            var obj = document.createElement('p');
            if (typeof params.text !== 'undefined') obj.innerHTML = params.text;

            // add specific styles
            if (typeof params.styles.cssClass !== 'undefined') obj.className = params.styles.cssClass;
            if (typeof params.styles.cssText !== 'undefined') obj.style.cssText = params.styles.cssText;

            return obj;
        }
    };

    /**
     *
     * Input text block
     *
     */
    blocks.dom.inputtext = function() {
        this.make = function(params) {
            // create element
            var obj = document.createElement('input');
            obj.type = "text";

            // add specific styles
            if (typeof params.styles.cssClass !== 'undefined') obj.className = params.styles.cssClass;
            if (typeof params.styles.cssText !== 'undefined') obj.style.cssText = params.styles.cssText;

            return obj;
        }
    };

    /**
     *
     * Button block
     *
     */
    blocks.dom.button = function() {
        this.make = function(params) {
            // create element
            var obj = document.createElement('button');
            if (typeof params.value !== 'undefined') obj.innerHTML = params.value;

            // add specific styles
            if (typeof params.styles.cssClass !== 'undefined') obj.className = params.styles.cssClass;
            if (typeof params.styles.cssText !== 'undefined') obj.style.cssText = params.styles.cssText;

            return obj;
        }
    };

    /**
     * Factory method to create blocks dynamically with specific type
     *
     * @param type
     */
    blocks.factory = function (type) {
        return new blocks.dom[type];
    };

    /**
     * Private method to render DOM
     *
     * @param arr
     * @param parent
     * @returns {*}
     */
    var rendererPrivateMethod = function(arr, parent) {
        var i, b;
        var co = Object.keys(arr).length;

        // create parent if it's not defined
        if (typeof parent === 'undefined') {
            var parent = document.createElement('div');
        }

        for (b = 0; b < co; b++) {
            var row = arr[b];

            var elem = blocks.factory(row.type).make(row);

            if (row.blocks) {
                var count = Object.keys(row.blocks).length;

                for (i = 0; i < count; i++) {
                    var line = row.blocks[i];

                    var subElem = blocks.factory(line.type).make(line);

                    elem.appendChild(subElem);

                    if (line.blocks) {
                        rendererPrivateMethod(line.blocks, subElem);
                    }
                }
            }

            parent.appendChild(elem);
        }

        return parent;
    }

    /**
     * Public method which is opened for outside
     *
     * @param json
     * @returns {*}
     */
    var domPublicMethod = function(json) {
        var parsed = JSON.parse(json);

        var result = rendererPrivateMethod(parsed);

        return result;
    }

    return {
        getDOM: domPublicMethod
    }
})();