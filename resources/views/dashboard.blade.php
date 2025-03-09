<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
     <!-- DataTable CSS (if you want to use DataTable) -->
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            padding: 20px;
        }
        .dashboard-container h1 {
            font-family:  "Times New Roman", Times, serif;
            font-size: 45px;
            color: #55565B;
        }
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
        .user-details {
            margin-top: 20px;
            width:25%; 
        }
        .user-details p {
            font-size: 16px;
        }
       
        .user-details img{
            display:block;
            margin:auto;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
    <h1>Welcome, {{ $userData['username'] }}</h1>
        
        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Log Out</button>
        </form>

        <!-- User Details Section -->
        @if ($userData)
            <div class="user-details">
                <h2>Authenticated User Details</h2>
                <img src="{{ $userData['image'] }}" alt="User"  width="100">
                <p><strong>Full Name:</strong> {{ $userData['firstName'] }} {{ $userData['lastName'] }}</p>
                <p><strong>Email:</strong> {{ $userData['email'] }}</p>
                <p><strong>Gender:</strong> {{ $userData['gender'] }}</p>
            </div>
        @else
            <p>Unable to fetch user details. Please log in again.</p>
        @endif

<hr>
     <h2>Products List</h2>   
     <!-- Display products in a table -->
     @if(count($productsData) > 0)
        <table id="productsTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Discount Percentage</th>
                    <th>Rating</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productsData as $product)
                    <tr>
                        <td>{{ $product['id'] }}</td>
                        <td>{{ $product['title'] }}</td>
                        <td>{{ $product['category'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['discountPercentage'] }}</td>
                        <td>{{ $product['rating'] }}</td>
                        <td>{{ $product['stock'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No products found.</p>
    @endif
    </div>

    <!-- jQuery and DataTable JS (for advanced table features) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- Initialize DataTable -->
    <script>
         $(document).ready( function () {
            $('#productsTable').DataTable({
                "pageLength": 10,  // Limit the number of products per page
                "paging": true,    // Enable pagination
                "lengthChange": false // Disable the option to change the page length
            });
        });
    </script>

</body>
</html>
