// scripts for IE

// string trimmer
if (!('trim' in String.prototype)) {
        String.prototype.trim = function () {
                return this.replace(/^\s*/, "").replace(/\s*$/, "");
        }
}

// the same for Array.indexOf
if (!('indexOf' in Array.prototype)) {
        Array.prototype.indexOf = function(elt /*, from*/) {
                var len = this.length;

                var from = Number(arguments[1]) || 0;
                from = (from < 0)
                        ? Math.ceil(from)
                        : Math.floor(from);

                if (from < 0) {
                        from += len;
                }

                for (; from < len; from++) {
                        if (
                                from in this &&
                                this[from] === elt
                        ) {
                                return from;
                        }
                }

                return -1;
        };
}

/* <debug> */
if (!('console' in window)) {
	console = {
		log: function(e) { },
		info: function(e) { },
		warn: function(e) { },
		group: function(e) { },
		groupEnd: function(e) { }
	};
}
/* </debug> */
