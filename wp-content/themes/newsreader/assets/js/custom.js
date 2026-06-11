// /js/page-specific.js
document.addEventListener("DOMContentLoaded", function () {
    function activateTabFromHash() {
        // Get the current hash (e.g. #legal, #staff)
        let hash = window.location.hash.substring(1);

        if (!hash) {
            hash = "mission"; // default tab if no hash
        }

        // Remove "is-active" from all tabs and panes
        document.querySelectorAll(".subpage-nav-item").forEach(el => el.classList.remove("is-active"));
        document.querySelectorAll(".tab-pane").forEach(el => el.classList.remove("is-active"));

        // Add "is-active" to the current tab + pane
        const activeTab = document.querySelector(`.subpage-nav-item[data-push-state="${hash}"]`);
        const activePane = document.getElementById(hash);

        if (activeTab) activeTab.classList.add("is-active");
        if (activePane) activePane.classList.add("is-active");
    }

    // Run on page load
    activateTabFromHash();

    // Also run when hash changes (user clicks tab or navigates with #)
    window.addEventListener("hashchange", activateTabFromHash);

    // Handle clicks on tabs so they update hash
    document.querySelectorAll(".subpage-nav-item").forEach(tab => {
        tab.addEventListener("click", function () {
            window.location.hash = this.dataset.pushState;
        });
    });
});
(function($) {
    $(document).ready(function() {
        /**
         * Update placeholders to indicate required status
         */
        var $requiredFieldContainers = $('li.gfield_contains_required');

        setTimeout(function () {
            $requiredFieldContainers.each(function (i, elem) {
                var $fields = $(elem).find('input,select');
                $fields.each(function (x, fieldElem) {
                    var $fieldElem = $(fieldElem);
                    var $placeholder = $fieldElem.attr('placeholder');

                    // Inputs
                    if ($placeholder) {
                        $fieldElem.attr('placeholder', $fieldElem.attr('placeholder') + ' *');
                        return;
                    }

                    // Selects
                    var selectedOption = $fieldElem.find('selectedoption:text');
                    var selectOptionText = $fieldElem.find('option:selected').text();

                    if (selectOptionText && 'State' === selectOptionText) {
                        $fieldElem.find('option:selected').text('State *');
                    }
                })
            });
        }, 45);


        /**
         * Expand Buttons
         */
        var $expandBioBtns = $('.js-expand-bio');

        $expandBioBtns.on('click', function () {
            var $this = $(this);
            var $contentBox = $this.closest('.team-item').find('.row-content');
            $contentBox.toggleClass('is-expanded');
            if ($contentBox.hasClass('is-expanded')) {
                $this.text('Hide Bio');
            } else {
                $this.text('Expand Bio');
            }
        });

        /**
         * Staff Filters
         */
        var $filterStaffInputs = $('.js-filter-staff');

        $filterStaffInputs.on('keyup', function() {
            var $searchInput = $(this);
            var $tabPane = $searchInput.closest('.tab-pane');
            var $items = $tabPane.find('.team-item');

            if (!$searchInput.val()) {
                $items.fadeIn();
                return;
            }

            $items.each(function(i, d) {
                var $item = $(d);
                var name = $item.find('h4').text().toLowerCase();

                if (name.indexOf($searchInput.val().toLowerCase()) !== -1) {
                    $item.fadeIn();
                } else {
                    $item.fadeOut();
                }
            });
        });

        /**
         * Anchor Link Padding
         */
        var aboutHash = window.location.hash.substring(1);
        console.log(aboutHash)
        if (aboutHash) {
            $('html,body').animate({
                scrollTop: $('#about_tabs').offset().top  - 150
            }, 'slow');
        }

        // ...existing code...

    /**
 * Newsletter Form Logic for .js-clonedNewsletterForm
 */
$(".component-newsletterForm").each(function () {
    var $component = $(this);
    var $gravityForm = $component.find("#gform_6");

    // Handle cloned newsletter form inside this component only
    $component.find(".js-clonedNewsletterForm").on("submit", function (e) {
        e.preventDefault();

        var $form = $(this);
        var $emailInput = $form.find(".input-newsletter");
        var $submitBtn = $form.find("button");
        var $gravityEmailInput = $gravityForm.find("#input_6_3");

        // Show spinner and disable button
        $submitBtn.html('<span class="fa fa-spinner fa-spin"></span>');
        $gravityEmailInput.val($emailInput.val());
        $submitBtn.attr("disabled", "disabled");

        // Collect other input values
        var extraFields = [];
        $form.find("input").each(function () {
            var $input = $(this);
            if ($input.attr("type") !== "email") {
                extraFields.push({
                    name: $input.attr("placeholder"),
                    value: $input.val()
                });
            }
        });

        // Add SourceID from URL if present
        var sourceId = new URLSearchParams(window.location.search).get("source");
        if (sourceId) {
            extraFields.push({
                name: "SourceID",
                value: parseInt(sourceId)
            });
        }

        // Trigger custom event only for this component's Gravity Form
        $gravityForm.trigger("submitForm", [$form, extraFields]);
    });

    // Listen for custom submitForm event in this component only
    $gravityForm.on("submitForm", function (event, $form, extraFields) {
        var $form = $($form);

        // Add extra fields to Gravity Form
        $.each(extraFields, function (i, field) {
            var name = field.name;
            var value = field.value;
            if (name) {
                var $virtualField = $gravityForm.find(".virtual-field_" + name);
                if ($virtualField.length) {
                    $virtualField.val(value);
                } else {
                    $gravityForm.append('<input name="virtual_fields[' + name + ']" type="hidden" value="' + value + '"/>');
                }
            }
        });

        // Reset validation messages only inside this component
        $form.find(".validation-message").hide();
        $gravityForm.find(".validation_message").html("");
        $gravityForm.submit();

        // Poll for Gravity Form validation message and show it only in this component
        var poll = setInterval(function () {
            var $validationMsg = $gravityForm.find(".validation_message");
            if ($validationMsg.length && $validationMsg.text().length) {
                var msg = $validationMsg.text();
                var $formMsg = $form.find(".validation-message");
                var $submitBtn = $form.find("button");
                $formMsg.html(msg).fadeIn();
                $submitBtn.html("Subscribe").attr("disabled", null);
                clearInterval(poll);
            }
        }, 100);
    });
});


// ...existing code...
    });
})(jQuery);
