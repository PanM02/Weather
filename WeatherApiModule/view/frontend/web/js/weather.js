define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';
    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.weather = customerData.get('weather');
            let data = this.weather();

            setInterval(function timer()
            {
                if (data.hasOwnProperty('condition') )
                {
                let now = new Date;
                let currentDate = Date.UTC(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate() ,
                    now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds(), now.getUTCMilliseconds());
                currentDate -= 3600000;
                let fetchDate = new Date(data.date);
                let diff = Math.abs(currentDate - fetchDate.getTime());
                diff /= 1000;
                if(diff > 600)
                    customerData.reload(['weather']);
                }
                this.weather = customerData.get('weather');
                data = this.weather();
            }, 300000);
        }
    });
});
