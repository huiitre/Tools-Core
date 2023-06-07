Exemple d'un call http d'une api à une autre : 

```php
try {
        $response = $client->request('GET', 'http://localhost:8080/api/gestion-essence/list?page=2');
        $statusCode = $response->getStatusCode();

        return $this->json([
            'response' => $response,
            'statusCode' => $statusCode
        ]);
    } catch (ClientException $e) {
        if ($e->getResponse()->getStatusCode() === 401) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);
    
            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Unknown error';
    
            return new JsonResponse(['msg' => 'JWT Token not found', 'error' => $errorMessage], Response::HTTP_UNAUTHORIZED);
        } else {
            // Gérer d'autres erreurs de client ici si nécessaire
        }
    } catch (Exception $e) {
        if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 401) {
            $responseBody = $e->getResponse()->getBody()->getContents();

            $responseData = json_decode($responseBody, true);
            dd('responseData : ', $responseData);
    
            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Unknown error';
    
            return new JsonResponse(['msg' => 'JWT Token not found', 'error' => $errorMessage], Response::HTTP_UNAUTHORIZED);
        } else {
            // Gérer d'autres erreurs de requête ici si nécessaire
        }
    }
```