import React from 'react';
import ReactDOM from 'react-dom';
import * as newPickup_module from './../../newPickup';
import Adapter from 'enzyme-adapter-react-16';
import { shallow, configure } from 'enzyme';

import Confirm from './../Confirm';


export function prevStep(){
    const result = newPickup_module.nextStep;
    return result;
}

export const values = {
    date: '"2020-04-01 00:00:00"',
    time: 8,
    phoneNo: '0763914094',
    address: 'Sanhinda, Komarikagoda, Bandarawela',
    municipal: 'Bandarawela'
};

configure({adapter: new Adapter()});
describe('Confirm', () => {

  it('fetches data from server when server returns a successful response', done => { // 1
    const mockSuccessResponse = {};
    const mockJsonPromise = Promise.resolve(mockSuccessResponse); // 2
    const mockFetchPromise = Promise.resolve({ // 3
      json: () => mockJsonPromise,
    });
    jest.spyOn(global, 'fetch').mockImplementation(() => mockFetchPromise); // 4
    
    const wrapper = shallow(<Confirm
        values = {values}
        prevStep = {prevStep}
        />); // 5

        const event = { preventDefault: () => {} }
        wrapper.instance().continue(event);  
        let bearer = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpZCI6IjEwMDI1IiwidGVsZSI6IjA3NjM5MTQwOTQifQ.WNgiEU-_GLzg6hFeeC9a35NzrnXCQsHYxc6DBOdBaGKhQlPgdw2YLNimLfwazLr_xlpsMCm-UA866utPuekLZm1Pl2UbIncwnlniwBGi9GPk0Xd0nm3JAVNS_gcLLlYbfni0QyTGIDlATg5N5dnb-lYaHCxO6wqBfOCevsUic6w';
        const data = {
            userPhone: values.phoneNo,
            timeslot: values.time,
            address: values.address,
            datatime: values.date,
         };

    expect(global.fetch).toHaveBeenCalledTimes(1);
    expect(global.fetch).toHaveBeenCalledWith('https://collector.ceykod.com/api/v1/pickups/new/', {
            method: 'POST',
            headers: {
               'Authorization': bearer,
            },
            body: JSON.stringify(data)
         });
    process.nextTick(() => { // 6

      global.fetch.mockClear(); // 7
      done(); // 8
    });
  });
});

