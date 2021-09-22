// https://angulartutorial.blogspot.com/2014/03/rating-stars-in-angular-js-using.html
import '../../../public/js/angular.min';
(function () {
    'use strict';
    angular
        .module('app', [])
        .controller('RatingController', RatingController)
        .directive('starRating', starRating);

    function RatingController() {
        this.qualificationHouseData = 0;
        this.qualificationHouseExperience = 0;
        this.qualificationHouseDevices = 0;
        this.qualificationHouseBath = 0;
        this.qualificationHouseRoomies = 0;
        this.qualificationHousewifi = 0;
        this.qualificationRoomswifi = 0;
        this.qualificationRoomsData = 0;
        this.qualificationRoomsGeneral = 0;
        this.qualificationRoomsLoud = 0;
        this.qualificationRoomswifi = 0;
        this.qualificationNeighborhoodsGeneral = 0;
        this.qualificationNeighborhoodsAccess = 0;
        this.qualificationNeighborhoodsShopping = 0;
        this.qualificationUsersManagerCommunication = 0;
        this.qualificationUsersManagerComprise = 0;
        this.qualificationManagerClean = 0;
        this.qualificationManagerComunication = 0;
        this.qualificationManagerRules = 0;
        this.isReadonly = false;
    }

    function starRating() {
        return {
            restrict: 'EA',
            template: '<ul class="star-rating" ng-class="{readonly: readonly}">' +
                '  <li ng-repeat="star in stars" class="star" ng-class="{filled: star.filled}" ng-click="toggle($index)">' +
                '    <i class="">&#9733</i>' + // or &#9733
                '  </li>' +
                '</ul>',
            scope: {
                ratingValue: '=ngModel',
                max: '=?', // optional (default is 5)
                onRatingSelect: '&?',
                readonly: '=?'
            },
            link: function (scope, element, attributes) {
                if (scope.max == undefined) {
                    scope.max = 5;
                }

                function updateStars() {
                    scope.stars = [];
                    for (var i = 0; i < scope.max; i++) {
                        scope.stars.push({
                            filled: i < scope.ratingValue
                        });
                    }
                };
                scope.toggle = function (index) {
                    if (scope.readonly == undefined || scope.readonly === false) {
                        scope.ratingValue = index + 1;
                        scope.onRatingSelect({
                            rating: index + 1
                        });
                    }
                };
                scope.$watch('ratingValue', function (oldValue, newValue) {
                    if (newValue || newValue === 0) {
                        updateStars();
                    }
                });
            }
        };
    }
})();