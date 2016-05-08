<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Simple Login with CodeIgniter - Private Area</title>
	<script type="text/javascript">

		app.controller('UserViews',function($scope,$http,$interval){

			$scope.users = [];
			$scope.assign=[];
			$scope.bid=[];
			$scope.noti=[{'a':0}];
			$scope.new=[{'b':0}];
			$scope.count=0;
			$scope.tag="";
			$scope.value="";			

			$scope.notification=function(){
				$http.get("<?php echo site_url('Angular/get_noti'); ?>").success(function($data){
					$scope.noti=$data; });
				$http.get("<?php echo site_url('Angular/get_newnoti'); ?>").success(function($data){
					$scope.new=$data; });
				$scope.count=$scope.new[0].b-$scope.noti[0].a;
				$http.get("<?php echo site_url('Angular/bid'); ?>").success(function($data){
					$scope.bid=$data; 
				});
				$http.get("<?php echo site_url('Angular/getAssign'); ?>").success(function($data){
					$scope.assign=$data;  });
				$scope.count=$scope.new[0].b-$scope.noti[0].a;


			}

			$scope.oldcountSet=function(){
				$http.post("<?php echo site_url('Angular/setOld'); ?>"+"/"+$scope.new[0].b).success(function(){
				});
			}


			$scope.setQuery=function($query,$tag){
				$http.get("<?php echo site_url('Angular/setQues'); ?>"+"/"+$query+"/"+$tag).success(function($data){
					$scope.assign=$data; 
				});
			}
			$scope.bidAccept=function($lawyer,$assign){
				$http.get("<?php echo site_url('Angular/bidAcc'); ?>"+"/"+$lawyer+"/"+$assign).success(function($data){
					$scope.bid=$data; 
				});
			}
			$scope.notification();
			$interval( function(){ $scope.notification(); }, 1000);

		});

		app.controller('LawyerViews',function($scope,$http,$interval){
			$scope.tag=true;
			$scope.tags=[];
			$scope.open=[];
			$scope.bids=[];
			$scope.assign=[];
			$scope.ids=[];
			$scope.num=0;
			$scope.noti=[{'a':0}];
			$scope.new=[{'b':0}];
			$scope.count=0;


			$http.get("<?php echo site_url('Angular/tagset'); ?>").success(function($data){
				$scope.tag=$data; 
			});

			$scope.assignSets=function(){
				$http.get("<?php echo site_url('Angular/getOpenre'); ?>").success(function($data){
					$scope.open=$data;
				});
				$http.get("<?php echo site_url('Angular/assignDone'); ?>").success(function($data){
					$scope.assign=$data;
					angular.forEach($scope.assign,function(value,index){
						$scope.ids.push(value.assignid);
					});
				});
			}

			$scope.assignSet=function(){
				
				$http.get("<?php echo site_url('Angular/bids'); ?>").success(function($data){
					$scope.bids=$data; 
				});
				$http.get("<?php echo site_url('Angular/get_noti'); ?>").success(function($data){
					$scope.noti=$data; });
				$http.get("<?php echo site_url('Angular/get_newnotiLawyer'); ?>").success(function($data){
					$scope.new=$data; });
				$scope.count=$scope.new[0].b-$scope.noti[0].a;
			}

			$scope.oldcountSet=function(){
				$http.post("<?php echo site_url('Angular/setOld'); ?>"+"/"+$scope.new[0].b).success(function(){
				});
			}



			$scope.bidInsert=function($assign,$value){
				$http.post("<?php echo site_url('Angular/bidIn'); ?>"+"/"+$assign+"/"+$value).success(function(){
				});
				$scope.assignSet();
				$scope.assignSets();
			}

			$scope.assignSet();
			$scope.assignSets();
			$scope.setData=function($tags){
				$scope.tag=true;				
				angular.forEach($tags,function(value,index){
					$http.post("<?php echo site_url('Angular/tagData'); ?>"+"/"+value).success(function($data){
					});
				});

			}
			$interval( function(){ $scope.assignSet(); }, 1000);
			$interval( function(){ $scope.assignSets(); }, 10000);
		});



	</script>
</head>
<body >
	<br>
	<?php if($type==0) {?>
	<div class="row" ng-controller="UserViews" ng-app="user">
		<div class="col-sm-9"></div>
		<div class="col-sm-2">
			<span class="badge"  style="width:15%;">{{count}} </span>
			<button class="form-control" style="width:85%; float:right;" ng-click="oldcountSet(); check=1;" ng-show="check==undefined || check==2">Notifications</button>
			<button class="form-control" style="width:85%; float:right;" ng-click="check=2" ng-show="check==1">Open Bids</button>
		</div>

		<div class="row">
			<div class="col-sm-6">

				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<h2>New Assignment:</h2>
						<form>
							<div class="row">
								<div class="col-sm-3">Query:</div>
								<div class="col-sm-9"> 
									<textarea  class="form-control" placeholder="Place Query" ng-model="value"></textarea>
								</div> 
							</div>
							<br>
							<div class="row">
								<div class="col-sm-3">Tag:</div>
								<div class="col-sm-9">
									<select class="form-control" ng-model="tag">
										<option class="form-control" value="Administrative">Administrative</option>	
										<option value="Admiralty" class="form-control">Admiralty</option>	
										<option value="Advertising" class="form-control">Advertising</option>	
										<option value="Animal" class="form-control">Animal </option>	
										<option value="Antitrust" class="form-control">Antitrust </option>	
									</select>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-9">
									<button ng-click="setQuery(value, tag);" class="form-control" >Submit</button>
								</div>
							</div>	
							<br>
						</form>
					</div>
				</div>


				<div class="row">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-8">
						<h2>Active Assignments:</h2>
						<table class="table" style="width: 100%;">
							<thead>
								<tr>
									<th>Assign</th>
									<th>Tag</th>
									<th>Final</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="x in assign">
									<td style="width: 33%;">{{x.ques}}</td>
									<td style="width: 33%;">{{x.tag}}</td>
									<td ng-show="x.final==-1" style="width: 33%;">Active</td>
									<td ng-show="x.final!=-1" style="width: 33%;">Closed Assigned To {{x.final}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="row" ng-show="check!=1">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-8">
						<h2>Bids:</h2>
						<table class="table" style="width: 100%;">
							<thead>
								<tr>
									<th>Assign</th>
									<th>LawyerID</th>
									<th>BidAmount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="x in bid">
									<td style="width: 25%;">{{x.ques}}</td>
									<td style="width: 25%;">{{x.lawyerid}}</td>
									<td style="width: 25%;">{{x.id}}</td>
									<td ng-show="x.final==-1" style="width: 25%;">
										<button class="form-control" ng-click="bidAccept(x.lawyerid,x.id)">
											Accept
										</button>	
									</td>
									<td ng-show="x.final!=-1" style="width: 25%;">Closed Assigned To {{x.final}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="row" ng-show="check==1" ng-repeat="x in bid">
					<br>
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10" >

						Lawyer {{x.lawyerid}} placed bid on {{x.assignid}} for amount {{x.bid}} at {{x.date}}			

					</div>
					<hr>
				</div>
			</div>
		</div>
	</div> <?php } else{?>

	<div ng-controller="LawyerViews" ng-app="user">
		<div class="row">
		<div class="col-sm-9" ng-show="tag==true"></div>
		<div class="col-sm-2" ng-show="tag==true">
			<span class="badge"  style="width:15%;">{{count}} </span>
			<button class="form-control" style="width:85%; float:right;" ng-click="oldcountSet(); check=1;" ng-show="check==undefined || check==2">Notifications</button>
			<button class="form-control" style="width:85%; float:right;" ng-click="check=2" ng-show="check==1">Open Bids</button>
		</div>
		</div>
		<div class="row">

			<div class="col-sm-4" ng-show="tag==false">
			</div>
			<div class="col-sm-4" ng-show="tag==false">
				<form ng-show="tag==false">
					<select name="tag" multiple="multiple" class="form-control" ng-model="tags" >
						<option class="form-control" value="Administrative">Administrative</option>  
						<option value="Admiralty" class="form-control">Admiralty</option> 
						<option value="Advertising" class="form-control">Advertising</option> 
						<option value="Animal" class="form-control">Animal </option>  
						<option value="Antitrust" class="form-control">Antitrust </option>  
					</select>
					<button class="form-control" ng-click="setData(tags)">Tag Submit</button>
				</form>

			</div>
			<div class="col-sm-1" ng-show="tag==true">
			</div>
			<div class="col-sm-5" ng-show="tag==true">
				<h2 >Open Assign:</h2>
				<table class="table" style="width: 100%;">
					<thead>
						<tr>
							<th>Assign</th>
							<th>UserID</th>
							<th>Tag</th>
							<th>Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="x in open" ng-show="x.final==-1 && ids.indexOf(x.id)==-1">

							<td style="width: 20%;">{{x.ques}}</td>
							<td style="width: 20%;">{{x.userid}}</td>
							<td style="width: 20%;">{{x.tag}}</td>
							<td style="width: 20%;">
								<input type="text" ng-model="num" class="form-control" placeholder="Bid">
							</td>
							<td  style="width: 20%;">
								<button class="form-control" ng-click="bidInsert(x.id,num)" >
									Accept
								</button>	
							</td>
						</tr>
					</tbody>
				</table>


			</div>
			<div class="col-sm-5" ng-show="tag==true && check!=1">
				<h2 >Previous Bids:</h2>
				<table class="table" style="width: 100%;">
					<thead>
						<tr>
							<th>Assign</th>
							<th>UserID</th>
							<th>Tag</th>
							<th>Amount</th>

						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="y in bids">

							<td style="width: 25%;">{{y.ques}}</td>
							<td style="width: 25%;">{{y.id}}</td>
							<td style="width: 25%;">{{y.bid}}</td>
							<td  style="width: 25%;" ng-show="y.final==<?php echo $id ?> ">Accepted
							</td>
							<td  style="width: 25%;" ng-show="y.final==-1">Pending
							</td>
								<td  style="width: 25%;" ng-show="y.final!=-1 && y.final!=<?php echo $id ?> ">Rejected</td>
							</tr>
						</tbody>
					</table>


				</div>	
				<div class="col-sm-5" ng-show="tag==true && check==1">
				<br>
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div ng-repeat="y in bids">
					User {{y.userid}} 
					<span ng-show="y.final==<?php echo $id ?> ">Accepted</span>
					<span ng-show="y.final==y.final!=-1 && y.final!=<?php echo $id ?>  ">Rejected</span>
					Your request for assignemt {{y.id}}
					<hr>
					</div>
				</div></div>

			</div>

		</div>
		<?php } ?>
		<a href="home/logout">Logout</a>
	</body>
	</html>