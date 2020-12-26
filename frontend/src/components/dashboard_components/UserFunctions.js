
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

export const newPickup = pickup => {
   //let userToken = getUserToken();
   //let bearer = 'Bearer ' + userToken;
   let bearer = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpZCI6IjEwMDI1IiwidGVsZSI6IjA3NjM5MTQwOTQifQ.WNgiEU-_GLzg6hFeeC9a35NzrnXCQsHYxc6DBOdBaGKhQlPgdw2YLNimLfwazLr_xlpsMCm-UA866utPuekLZm1Pl2UbIncwnlniwBGi9GPk0Xd0nm3JAVNS_gcLLlYbfni0QyTGIDlATg5N5dnb-lYaHCxO6wqBfOCevsUic6w';

   const data = {
      userPhone: pickup.phoneNo,
      timeslot: pickup.time,
      address: pickup.address,
      datatime: pickup.date,
   };
   return fetch('https://collector.ceykod.com/api/v1/pickups/new/', {
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

export const getUserData = () => {
   let userToken = getUserToken();
   let bearer = 'Bearer ' + userToken;
   //let bearer = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpZCI6IjEwMDI1IiwidGVsZSI6IjA3NjM5MTQwOTQifQ.WNgiEU-_GLzg6hFeeC9a35NzrnXCQsHYxc6DBOdBaGKhQlPgdw2YLNimLfwazLr_xlpsMCm-UA866utPuekLZm1Pl2UbIncwnlniwBGi9GPk0Xd0nm3JAVNS_gcLLlYbfni0QyTGIDlATg5N5dnb-lYaHCxO6wqBfOCevsUic6w';
        
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

export const getListItems = () => {
   let userToken = getUserToken();
   console.log(userToken);
   let bearer = 'Bearer ' + userToken;
   return fetch(global.config.backend + '/api/v1/pickups/list', {
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

export const ratePickup = pickup => {
   let userToken = getUserToken();
   let bearer = 'Bearer ' + userToken;

   const data = {
      pickupId: pickup.pickupId,
      rate: pickup.rate,
   };

   return fetch(global.config.backend + '/api/v1/pickups/rate/', {
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

export const deletePickup = pickup => {
   let userToken = getUserToken();
   let bearer = 'Bearer ' + userToken;

   const data = {
      pickupId: pickup.pickupId,
   };

   return fetch(global.config.backend + '/api/v1/pickups/delete/', {
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
