var DynamicModel = function (items) {
    var self = this;
    self.items = ko.observableArray(ko.utils.arrayMap(items, function (item) { return item; }));
    self.refill = function (newvals,oncheck) {
        self.items.removeAll();
        for (var i = 0; i < newvals.length; i++) {
            if (!!oncheck) {
                if (!oncheck(newvals[i])) {
                    continue;
                }
            }
            self.items.push(newvals[i]);
        }
    }
}