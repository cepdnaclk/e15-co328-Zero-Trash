

export const getUserToken = () => {

    const tokenStr = localStorage.getItem('usertoken')
 
     if (!tokenStr) {
       window.location.href = '/login';
    }
    
     const token = JSON.parse(tokenStr)
     const current_time = new Date()
     if (current_time.getTime() > token.expiry) {
         localStorage.removeItem('usertoken')
         window.location.href = '/login';
    }
    let ttl = 1000*60*15;
    const usertoken = {
       value: token.value,
       expiry: current_time.getTime() + ttl,
    }
    console.log('token updated');
     return token.value;
}

export const getUserData = () => {
    let userToken = getUserToken();
    let bearer = 'Bearer ' + userToken;
    return fetch(global.config.backend + '/api/v1/getUserData/', {
       method: 'GET',
       headers: {
          'Authorization': bearer,
       }
    })
    .then((response) => response.json())
    .then(response => {
       return response;
    })
    .catch(err => {
       console.log(err)
    })
}

export const changeDetails = customer => {
   let userToken = getUserToken();
   let bearer = 'Bearer ' + userToken;

   const data = {
      firstName: customer.firstName,
      lastName: customer.lastName,
      address1: customer.address1,
      address2: customer.address2,
      city: customer.city,
      language: customer.language,
      municipalCouncil: customer.municipalCouncil,
   };

   return fetch(global.config.backend + '/api/v1/setUserData/', {
      method: 'POST',
      headers: {
         'Authorization': bearer,
      },
      body: JSON.stringify(data)
   })
   .then((response) => response.json())
   .then(response => {
      return response;
   })
   .catch(err => {
      console.log(err)
   })
}

export const changePasswordDetails = customer => {
   let userToken = getUserToken();
   let bearer = 'Bearer ' + userToken;

   const data = {
      old: customer.old,
      new: customer.new
   };
   console.log(data);
   return fetch(global.config.backend + '/api/v1/setPassword/', {
      method: 'POST',
      headers: {
         'Authorization': bearer,
      },
      body: JSON.stringify(data)
   })
   .then((response) => response.json())
   .then(response => {
      return response;
   })
   .catch(err => {
      console.log(err)
   })
}
