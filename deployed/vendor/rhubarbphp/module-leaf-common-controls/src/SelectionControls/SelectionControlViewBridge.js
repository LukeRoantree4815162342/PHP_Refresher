var selectionControl = function (leafPath) {
    window.rhubarb.viewBridgeClasses.ViewBridge.apply(this, arguments);

    /**
     * Set to false if the selection control can't support multiple selections
     * at once.
     *
     * @type {boolean}
     */
    this.supportsMultipleSelection = true;
};

selectionControl.prototype = new window.rhubarb.viewBridgeClasses.ViewBridge();
selectionControl.prototype.constructor = selectionControl;

selectionControl.prototype.setCurrentlyAvailableSelectionItems = function (items) {

};

selectionControl.prototype.setValue = function (value) {
    this.viewNode.value = value;

    this.model.selectedItems = [{"value": value}];
};

selectionControl.prototype.getValue = function () {
    // If the control only supports a single selection then just return
    // the first of the selected items (or false if none selected)
    if (!this.supportsMultipleSelection) {
        if (this.model.selectedItems.length > 0) {
            return this.model.selectedItems[0].value;
        }
        else {
            return false;
        }
    }
    else {
        var values = [];

        var checkedBoxes = this.viewNode.querySelectorAll('input:checked');
        for (var i = 0; i < checkedBoxes.length; i++) {
            values.push(checkedBoxes[i].value);
        }

        return values;
    }
};

selectionControl.prototype.setSelectedItems = function (items) {
    this.model.selectedItems = items;
};

selectionControl.prototype.getSelectedItems = function () {
    return this.model.selectedItems;
};

/**
 * Returns the first of the selected item objects
 *
 * @returns {*|selectedItems}
 */
selectionControl.prototype.getSelectedItem = function () {
    if (this.model.selectedItems.length <= 0) {
        return false;
    }

    return this.model.selectedItems[0];
};

selectionControl.prototype.isValueSelected = function (value) {
    return this.getSelectedKeyFromValue(value) != -1;
};

selectionControl.prototype.getSelectedKeyFromValue = function (value) {
    for (var i in this.model.selectedItems) {
        if (i != "length" && this.model.selectedItems[i].value == value) {
            return i;
        }
    }
    return -1;
};

selectionControl.prototype.unSelectItemWithValue = function (value) {
    for(var i = 0; i < this.model.selectedItems.length; i++){
        if (this.model.selectedItems[i].value == value){
            this.model.selectedItems.splice(i,1);
            return;
        }
    }
};

selectionControl.prototype.hasValue = function () {
    return true;
};

selectionControl.prototype.fetchAvailableSelectionItems = function () {
    var params = ["UpdateAvailableSelectionItems"];

    for (var i = 0; i < arguments.length; i++) {
        params[params.length] = arguments[i];
    }

    var self = this;

    params[params.length] = function (items) {
        self.setCurrentlyAvailableSelectionItems(items);
    };

    this.raiseServerEvent.apply(this, params);
};

selectionControl.prototype.getCssDisplayType = function () {
    return 'inline-block';
};

window.rhubarb.viewBridgeClasses.SelectionControlViewBridge = selectionControl;
