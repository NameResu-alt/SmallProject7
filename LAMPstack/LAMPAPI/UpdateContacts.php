
<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");

$inData = getRequestInfo();

$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
if ($conn->connect_error) 
{
    returnWithError( $conn->connect_error );
} 
else
{
    $neededFieldNames = ["contactid","firstname","lastname", "email", "phone"];

    foreach($neededFieldNames as $fieldName)
    {
        if(!isset($inData[$fieldName]))
        {
            http_response_code(400);
            $data = [];
            $data["error"] = "Body is missing $fieldName";
            echo json_encode($data);
            return;
        }
    }

    if ($inData["lastname"] != "")
    {
        try
        {
            $stmt = $conn->prepare("UPDATE Contacts SET LastName  = ? WHERE ID = ?");
            $stmt->bind_param("si", $inData["lastname"], $inData["contactid"]);
            $stmt->execute();
        }
        catch(exception)
        {
            $msg["error"] = "unsuccessful";
            http_response_code(409);
            sendResultInfoAsJson($msg);
            $stmt->close();
            $conn->close();
        }
    }
    if ($inData["firstname"] != "")
    {
        try
        {
            $stmt = $conn->prepare("UPDATE Contacts SET FirstName  = ? WHERE ID = ?");
            $stmt->bind_param("ss", $inData["firstname"], $inData["contactid"]);
            $stmt->execute();
            
        }
        catch(exception)
        {
            $msg["error"] = "unsuccessful";
            http_response_code(409);
            sendResultInfoAsJson($msg);
            $stmt->close();
            $conn->close();
        }

        //$stmt->close();
        //$conn->close();
    }
    if ($inData["email"] != "")
    {
        try
        {
            $stmt = $conn->prepare("UPDATE Contacts SET Email  = ? WHERE ID = ?");
            $stmt->bind_param("ss", $inData["email"], $inData["contactid"]);
            $stmt->execute();
        }
        catch(exception)
        {
            $msg["error"] = "unsuccessful";
            http_response_code(409);
            sendResultInfoAsJson($msg);
            $stmt->close();
            $conn->close();
        }

        //$stmt->close();
        //$conn->close();
    }
    if ($inData["phone"] != "")
    {
        try
        {
            $stmt = $conn->prepare("UPDATE Contacts SET Phone  = ? WHERE ID = ?");
            $stmt->bind_param("ss", $inData["phone"], $inData["contactid"]);
            $stmt->execute();
            
        }
        catch(exception)
        {
            $msg["error"] = "unsuccessful";
            http_response_code(409);
            sendResultInfoAsJson($msg);
            $stmt->close();
            $conn->close();
        }

    }

    $affected = $conn->affected_rows;

    if($affected == 0)
    {
        http_response_code(404);
        $msg = array();
        $msg["error"] = "No records found";
        echo json_encode($msg);
        return;
    }
    else
    {
        http_response_code(200);
        $msg["error"] = "";
        sendResultInfoAsJson($msg);
    }

    $stmt->close();
    $conn->close();
}

function getRequestInfo()
{
return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson( $obj )
{
echo json_encode($obj);
}

?>
