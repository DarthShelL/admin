(function () {
    document.addEventListener("click", function (e) {
        switch (e.target.tagName) {
            case 'SPAN':
            case 'A':
                let el = e.target;
                let li = el.parentNode;

                if (el.className == 'dsa-item' && li.tagName == 'LI') {
                    // check if element is in the top level of menu
                    if (li.parentNode.className == 'dsa-menu') {
                        // remove all active className from top level menu
                        let activeList = document.querySelectorAll('.dsa-menu li.active');

                        for (let item of activeList) {
                            item.classList.remove('active');
                        }

                        li.classList.add('active');
                    }

                }
                break;
        }

    });
})(window, document);
