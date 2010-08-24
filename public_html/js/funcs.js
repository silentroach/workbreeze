var is_ls = false;

function finit() {
	is_ls = ('undefined' != typeof(localStorage));
}

/**
 * Check leading zero in single char int
 * @param {!number} i Number
 * @return {string}
 */
function checkTimeVal(i) {
        if (i < 10) {
                i = "0" + i;
        }

        return i;
}

