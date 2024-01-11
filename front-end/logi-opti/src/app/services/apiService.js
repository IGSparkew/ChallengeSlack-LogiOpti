export class ApiService {
    constructor(baseURL = "") {
      this.baseURL = baseURL;
      if (this.baseURL == "") {
        this.baseURL="http://localhost:8000"
      }
    }
  
    async get(endpoint, token, queryParams = {}) {
      const url = this.baseURL + endpoint; 
      
      const headers =  {
        'Content-Type': 'application/json',
      }

      Object.keys(queryParams).forEach(key =>
        url.searchParams.append(key, queryParams[key])
      );


      if (token && token != "") {
        headers["Authorization"] = "Bearer " + token;
      }
  
      try {
        const response = await fetch(url, {
          method: 'GET',
          headers: headers,
        });
  
        if (!response.ok) {
          throw new Error(`Erreur HTTP! Statut: ${response.status}`);
        }
  
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Une erreur s\'est produite lors de la requête:', error);
        throw error;
      }
    }

    async post(endpoint, body, token="") {
        const url = this.baseURL + endpoint; 
        const headers = {
            'Content-Type': 'application/json',
        };

        if (token && token != "") {
            headers["Authorization"] = "Bearer " + token;
        }

        if (body == null) {
            throw new Error('body is null!');
        }

        try {
          const response = await fetch(url, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(body),
          });
    
          if (!response.ok) {
            throw new Error(`Erreur HTTP! Statut: ${response.status}`);
          }
    
          const data = await response.json();
          return data;
        } catch (error) {
          console.error('Une erreur s\'est produite lors de la requête:', error);
          throw error;
        }
      }

      async update(endpoint, body, token="", isPatch = false) {
        const url = this.baseURL + endpoint; 
        const headers = {
            'Content-Type': 'application/json',
        };

        let methods = "PUT";

        if (isPatch) {
            methods = "PATCH"
        }

        if (token && token != "") {
            headers["Authorization"] = "Bearer " + token;
        }

        if (body == null) {
            throw new Error('body is null!');
        }

        try {
          const response = await fetch(url, {
            method: methods,
            headers: headers,
            body: JSON.stringify(body),
          });
    
          if (!response.ok) {
            throw new Error(`Erreur HTTP! Statut: ${response.status}`);
          }
    
          const data = await response.json();
          return data;
        } catch (error) {
          console.error('Une erreur s\'est produite lors de la requête:', error);
          throw error;
        }
      }

      async delete(endpoint, token="") {
        const url = this.baseURL + endpoint; 
        const headers = {
            'Content-Type': 'application/json',
        };

        if (token && token != "") {
            headers["Authorization"] = "Bearer " + token;
        }

        if (body == null) {
            throw new Error('body is null!');
        }

        try {
          const response = await fetch(url, {
            method: 'DELETE',
            headers: headers,
          });
    
          if (!response.ok) {
            throw new Error(`Erreur HTTP! Statut: ${response.status}`);
          }
    
          const data = await response.json();
          return data;
        } catch (error) {
          console.error('Une erreur s\'est produite lors de la requête:', error);
          throw error;
        }
      }


  }
