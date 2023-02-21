
## Asteroid API based on NASA API, Asteroids - NeoWs (Near Earth Object Web Service).

Asteroid_api get the data from https://api.nasa.gov/ period of  last three days, then grouping it's for reference, name, speed, hazardous,
date.
## Requirements 
1. Docker
2. Makefile tool.
## Run Locally
Clone the project

```bash
  git clone https://github.com/Shumerok/asteroid.git asteroid_api
```

Go to the project directory

```bash
  cd asteroid_api
```
## Deployment
To deploy this project run:
```bash
make init 
```
### Go to:
1. http://localhost:8080/api/v1/ - hello 
2. http://localhost:8080/api/v1/neo/ - set or update data from https://api.nasa.gov/ 
3. http://localhost:8080/api/v1/neo/fastets - get fastest asteroids.
4. http://localhost:8080/api/v1/neo/fastest?hazardous=true - get fastest and hazardous asteroids order by speed "desc"  
5. http://localhost:8080/api/v1/neo/fastest?hazardous=true - get fastest and **_NOT_** hazardous asteroids order by speed "desc"

## Testing 

```bash
make test 
```

