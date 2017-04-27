var button = function (leafPath) {
    this.validation = false;
    this.validator = false;
    this.confirmMessage = false;

    window.rhubarb.viewBridgeClasses.ViewBridge.apply(this, arguments);

    if (arguments.length == 0) {
        return;
    }

    this.useXmlRpc = ( this.viewNode.getAttribute("xmlrpc") == "yes" );

    if (this.viewNode.getAttribute("confirm")) {
        this.confirmMessage = this.viewNode.getAttribute("confirm");
    }
};

button.prototype = new window.rhubarb.viewBridgeClasses.ViewBridge();
button.prototype.constructor = button;

button.prototype.attachEvents = function () {
    var self = this;

    this.viewNode.addEventListener('click',function(event) {

        if (self.confirmMessage) {
            if (!confirm(self.confirmMessage)) {
                event.preventDefault();
                return false;
            }
        }

        if (self.raiseClientEvent("OnButtonPressed") === false) {
            event.preventDefault();
            return false;
        }

        if (self.useXmlRpc) {
            var viewIndex = self.getViewIndex();
            self.raiseServerEvent(
                "buttonPressed",
                viewIndex,
                function (response) {
                    self.raiseClientEvent("ButtonPressCompleted", response);
                },
                function (response) {
                    self.raiseClientEvent("ButtonPressFailed", response);
                }
            );

            event.preventDefault();
            return false;
        }

        if (self.viewNode.classList.contains('submit-on-click') && self.viewNode.getAttribute('type') == 'button') {
            self.viewNode.setAttribute('type', 'submit');
            window.setTimeout(function () {
                self.viewNode.setAttribute('type', 'button');
            }, 1);
        }
    });
};

button.prototype.getCssDisplayType = function () {
    return 'inline-block';
};

window.rhubarb.viewBridgeClasses.ButtonViewBridge = button;
