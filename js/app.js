/*jshint globalstrict: true */
/*global angular: true, d3: true */

var app = angular.module('analytics', []);

/**
 * ranges
 */
app.value('ranges', [
  { name: 'Last 7 days',  value:  -7 },
  { name: 'Last 14 days', value: -14 },
  { name: 'Last 30 days', value: -30 },
  { name: 'All time',     value:   0 }
]);

/**
 * analyticsRange
 *
 * Range select to slice JSON data.
 * Injects `ranges` values.
 */
app.directive('analyticsRange', function(ranges) {
  return {
    replace: true,
    restrict: 'A',
    scope: {
      range: '=' // two-way binding
    },
    template: [
      '<div class="de-analytics-range">',
        '<select ng-model="range" class="form-control" ng-options="r.value as r.name for r in ranges"></select>',
      '</div>'
    ].join(''),
    link: function(scope) {
      scope.ranges = ranges;
      scope.range  = ranges[0].value;
    }
  };
});

/**
 * analyticsDates
 *
 * Show data date range according
 * to selected analyticsRange.
 * Injects `$http` service.
 */
app.directive('analyticsDates', function($http) {
  return {
    replace: true,
    restrict: 'A',
    scope: {
      range: '=', // two-way binding
      ajax:  '@', // one-way binding
    },
    template: [
      '<div>',
        '<div ng-hide="last" class="analytics-loading">Loading dates... One moment.</div>',
        '<div ng-show="last">{{ first }} to {{ last }}</div>',
      '</div>'
    ].join(''),
    link: function(scope, el, attr) {
      $http.get(scope.ajax)
        .success(function(json) {
          scope.last = json.dates.slice(-1)[0];
          scope.$watch('range', function(range) {
            scope.first = json.dates.slice(range)[0];
          });
        });
    }
  };
});

/**
 * analyticsMessages
 */
app.directive('analyticsMessages', function($window, $http) {
  return {
    replace: true,
    restrict: 'A',
    scope: {
      range: '=',
      ajax:  '@'
    },
    templateUrl: 'view/directive/analytics-messages.html',
    link: function(scope, element) {
      $http.get(scope.ajax)
        .error(function() {
          element.text('Sorry! No data was retrieved for this view. Please try again later.');
        })
        .success(function(json) {
          scope.$watch('range', function(range) {
            // get total for selected range
            scope.rangeTotal = json.messages.slice(range)
              .reduce(function(curr, prev) {
                return curr + prev;
              });

            // build chart
            $window.c3.generate({
              axis: {
                x: {
                  type: 'timeseries',
                  tick: {
                    fit: true,
                    format: '%e %b'
                  }
                }
              },
              bindto: '#analytics-messages',
              data: {
                x: 'Date',
                columns: [
                  ['Date'].concat(json.date.slice(range)),
                  ['Messages'].concat(json.messages.slice(range))
                ],
                type: 'spline',
              },
              grid: {
                y: {
                  show: true
                }
              },
              zoom: {
                enabled: (range === 0) // enable zoom for 'All Time' view
              }
            });
          });
        });
    }
  };
});

/**
 * analyticsCurrencies
 */
app.directive('analyticsCurrencies', function($window, $http) {
  return {
    replace: true,
    restrict: 'A',
    scope: {
      range: '=',
      ajax:  '@'
    },
    templateUrl: 'view/directive/analytics-currencies.html',
    link: function(scope, element) {
      $http.get(scope.ajax)
        .error(function() {
          element.text('Sorry! No data was retrieved for this view. Please try again later.');
        })
        .success(function(json) {
          scope.$watch('range', function(range) {

          });
        });
    }
  };
});

/**
 * analyticsCountries
 */
app.directive('analyticsCountries', function($window, $http) {
  return {
    replace: true,
    restrict: 'A',
    scope: {
      range: '=',
      ajax:  '@'
    },
    templateUrl: 'view/directive/analytics-countries.html',
    link: function(scope, element) {
      $http.get(scope.ajax)
        .error(function() {
          element.text('Sorry! No data was retrieved for this view. Please try again later.');
        })
        .success(function(json) {
          scope.$watch('range', function(range) {
            // build columns
            scope.columns = json.map(function(country) {
              // apply range and sum value
              var rangeTotal = country.data.slice(range)
                .reduce(function(curr, prev) {
                  return curr + prev;
              });
              return [country.name, rangeTotal];
            });

            // build chart
            $window.c3.generate({
              bindto: '#analytics-countries',
              data: {
                columns: scope.columns,
                type : 'donut'
              },
              donut: {
                title: 'Countries'
              }
            });
          });
        });
    }
  };
});
