document.addEventListener("DOMContentLoaded", function() {
    var headings = document.querySelectorAll("h2");

    headings.forEach(function(heading) {
        heading.addEventListener("click", function() {
            this.classList.toggle("active");
            var nextElement = this.nextElementSibling;

            // Toggle visibility of the elements after the heading
            while (nextElement && nextElement.tagName !== 'H2') {
                if (nextElement.style.display === "block") {
                    nextElement.style.display = "none";
                } else {
                    nextElement.style.display = "block";
                }
                nextElement = nextElement.nextElementSibling;
            }
        });
    });
});
