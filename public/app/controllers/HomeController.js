// Admin Controller
app.controller('AdminController', function($scope,$http)
{
    $scope.pools = [];
});

// Home Controller
app.controller('HomeController', function(dataFactory,$scope,$http)
{    
    // Settings
    $scope.status_select = {};
    $scope.status_select;
    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};
    $scope.totalItems = 0;

    $scope.pageChanged = function(newPage)
    {
        getResultsPage(newPage);
    };

    getResultsPage(1);

    // Load table
    function getResultsPage(pageNumber)
    {
        if(! $.isEmptyObject($scope.libraryTemp))
        {
            dataFactory.httpRequest('/workflow?search='+$scope.searchText+'&page='+pageNumber).then(function(data) {
                $scope.data = data.data;
                $scope.status = data.data.status;
                $scope.totalItems = data.total;
                $scope.item_num = data.from;
            });
        } else {
            dataFactory.httpRequest('/workflow?page='+pageNumber).then(function(data) {
                $scope.data = data.data;
                $scope.status = data.data.status;
                $scope.totalItems = data.total;
                $scope.item_num = data.from;
            });
        }
    }

    // Search
    $scope.searchDB = function()
    {
        if($scope.searchText.length >= 3)
        {
            if($.isEmptyObject($scope.libraryTemp)){
            $scope.libraryTemp = $scope.data;
            $scope.totalItemsTemp = $scope.totalItems;
            $scope.data = {};
        }

        getResultsPage(1);

        } else {
            if(! $.isEmptyObject($scope.libraryTemp))
            {
                $scope.data = $scope.libraryTemp ;
                $scope.totalItems = $scope.totalItemsTemp;
                $scope.libraryTemp = {};
            }
        }
    }

    // Status update
    $scope.status_update = function(type)
    {
        var scope, id;

        scope = $scope.status_select;
        id = Object.keys(scope);

        // update ng-selected="s.status_id == value.type"
        var value = id.map(function(key) {
            return scope[key];
        });

        this.value[type] = parseInt(value);

        // add type in status
        scope.type = type;

        // request
        dataFactory.httpRequest('home/'+id,'PUT',{},scope);

        // clear
        $scope.status_select = {};
    }

});