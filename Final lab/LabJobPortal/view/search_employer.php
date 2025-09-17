<?php
    require_once('../controller/adminActions.php');
    
    $allEmployers = getAllEmployersController();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Employer</title>
    <script>
        searchTimeout = null;
        
        function searchEmployers() {
            searchTerm = document.getElementById('search_term').value;
            
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open('POST', '../controller/adminActions.php', true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    try {
                        employers = JSON.parse(xmlhttp.responseText);
                        updateEmployerTable(employers, searchTerm);
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                }
            };
            
            xmlhttp.send('ajax_search=1&search_term=' + encodeURIComponent(searchTerm));
        }
        
        function updateEmployerTable(employers, searchTerm) {
            tableBody = document.getElementById('employer-table-body');
            resultInfo = document.getElementById('result-info');
            tableTitle = document.getElementById('table-title');
            
            tableBody.innerHTML = '';
            
            tableTitle.textContent = searchTerm ? 'Search Results' : 'All Employers';
            
            if (employers.length > 0) {
                for (i = 0; i < employers.length; i++) {
                    employer = employers[i];
                    row = document.createElement('tr');
                    row.innerHTML = 
                        '<td>' + employer.id + '</td>' +
                        '<td>' + employer.Emp_name + '</td>' +
                        '<td>' + employer.Company_name + '</td>' +
                        '<td>' + employer.Contact_No + '</td>' +
                        '<td>' + employer.User_Name + '</td>' +
                        '<td>' +
                            '<a href="update_info.php?id=' + employer.id + '">Edit</a> | ' +
                            '<a href="delete_employer.php">Delete</a>' +
                        '</td>';
                    tableBody.appendChild(row);
                }
                
                message = searchTerm ? 
                    'Found ' + employers.length + ' result(s).' : 
                    'Total: ' + employers.length + ' employer(s).';
                resultInfo.innerHTML = '<p>' + message + '</p>';
            } else {
                row = document.createElement('tr');
                row.innerHTML = '<td colspan="6" style="text-align: center; font-style: italic;">' +
                    (searchTerm ? 'No employers found matching your search criteria.' : 'No employers found in the database.') +
                    '</td>';
                tableBody.appendChild(row);
                resultInfo.innerHTML = '';
            }
        }
        
        function clearSearch() {
            document.getElementById('search_term').value = '';
            searchEmployers(); 
        }
        
        function handleSearchInput() {
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            searchTimeout = setTimeout(function() {
                searchEmployers();
            }, 500); // 500ms delay 
        }
    </script>
</head>
<body>
    <h2>Search Employer</h2>
    
    <div>
        <table>
            <tr>
                <td>Search by Name:</td>
                <td>
                    <input type="text" 
                           id="search_term" 
                           placeholder="Enter employer name" 
                           oninput="handleSearchInput()"
                           onkeyup="handleSearchInput()">
                </td>
                <td>
                    <button onclick="searchEmployers()">Search</button>
                    <button onclick="clearSearch()">Show All</button>
                </td>
            </tr>
        </table>
    </div>
    
    
    <h3 id="table-title">All Employers</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employer Name</th>
                <th>Company Name</th>
                <th>Contact No</th>
                <th>User Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="employer-table-body">
            <?php foreach($allEmployers as $employer): ?>
            <tr>
                <td><?php echo $employer['id']; ?></td>
                <td><?php echo $employer['Emp_name']; ?></td>
                <td><?php echo $employer['Company_name']; ?></td>
                <td><?php echo $employer['Contact_No']; ?></td>
                <td><?php echo $employer['User_Name']; ?></td>
                <td>
                    <a href="update_info.php?id=<?php echo $employer['id']; ?>">Edit</a> | 
                    <a href="delete_employer.php">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($allEmployers)): ?>
            <tr>
                <td colspan="6" style="text-align: center; font-style: italic;">No employers found in the database.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div id="result-info">
        <?php if(!empty($allEmployers)): ?>
            <p>Total: <?php echo count($allEmployers); ?> employer(s).</p>
        <?php endif; ?>
    </div>
    
    <br>
    <a href="admin.php">Back to Admin Panel</a>
</body>
</html>