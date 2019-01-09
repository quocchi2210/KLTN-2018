package com.example.quocchi.shipper_app;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Pickup_Fragment extends Fragment {
    private View mRootView;

    //private ArrayList<Order_Received> data = new ArrayList<Order_Received>();
    private String hostname = "luxexpress.cf";
    private String token = Login_Token.token;

    private CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    private OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

    private Shipper_Position_Send obj;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {

        mRootView = inflater.inflate(R.layout.fragment_pickup, container, false);
        Log.w("wtf1", "Order received eponse: " );
        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.0.132:8000/api/shipper/showOrderReceived")
                .url("https://luxexpress.cf/api/shipper/showOrderReceived")
                .post(requestBody)
                //.addHeader("name_your_token", "your_token")
                .addHeader("Authorization", "Bearer " + token)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if (response.isSuccessful()) {

                    getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {
                                ArrayList<Order_Received> data = new ArrayList<Order_Received>();
                                ListView list_view_order_received = (ListView) mRootView.findViewById(R.id.list_view_order_received);

                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");

                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);
                                    Log.w("myApp", "Order received: " + object.toString());
                                    String timeDelivery = object.getString("timeDelivery");
                                    String addressReceiver = object.getString("addressReceiver");
                                    String addressStore = object.getString("addressStore");
                                    String idOrder = object.getString("idOrder");
                                    String idOrderStatus = object.getString("idOrderStatus");

                                    String billOfLading = object.getString("billOfLading");
                                    String total_money = object.getString("totalMoney");
                                    String name_received = object.getString("nameReceiver");
                                    String phone_received = object.getString("phoneReceiver");

                                    if(billOfLading.equals("null")){
                                        billOfLading = "";
                                    }
                                    if(name_received.equals("null")){
                                        name_received = "";
                                    }
                                    if(phone_received.equals("null")){
                                        phone_received = "";
                                    }
                                    if(addressReceiver.equals("null")){
                                        addressReceiver = "";
                                    }
                                    if(total_money.equals("null")){
                                        total_money = "";
                                    }

                                    data.add(new Order_Received(addressReceiver, addressStore, timeDelivery, idOrder, idOrderStatus,billOfLading,total_money,name_received,phone_received));
                                }

                                list_view_order_received.setAdapter(new Order_Received_Adapter(getActivity(), R.layout.list_item_pickup, data));
                                Log.w("Order eponse", "Order received eponse: " + yourResponse.toString());
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });
                } else {
                    Log.w("myApp", "ERROR Order received: " + yourResponse.toString());
                }


            }
        });

        obj = Shipper_Position_Send.getInstance();
        obj.setMyContext(getActivity());

        return mRootView;
    }

    @Override
    public void setUserVisibleHint(boolean isVisibleToUser) {
        super.setUserVisibleHint(isVisibleToUser);
        if (isVisibleToUser) {
            getFragmentManager().beginTransaction().detach(this).attach(this).commit();
        }
    }

    private class Order_Received_Adapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order_Received> arrayOrder;

        public Order_Received_Adapter(Context context, int layout, List<Order_Received> orderList) {
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

           // TextView txt_address_delivery = (TextView) convertView.findViewById(R.id.txt_address_delivery);
          //  TextView txt_address_receive = (TextView) convertView.findViewById(R.id.txt_address_receive);
           // TextView txt_time = (TextView) convertView.findViewById(R.id.txt_time);
            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);
            TextView mobile_receive = (TextView) convertView.findViewById(R.id.mobile_receive);
            TextView name_receive = (TextView) convertView.findViewById(R.id.name_receive);
            TextView total_money = (TextView) convertView.findViewById(R.id.total_money);

           // Button btn_see_map = (Button) convertView.findViewById(R.id.btn_see_map);
            Button btn_done = (Button) convertView.findViewById(R.id.btn_done);

            LinearLayout btn_see_map = (LinearLayout) convertView.findViewById(R.id.btn_see_map);

            bill_of_lading.setText("Order " + arrayOrder.get(position).getBillOfLading());
            address.setText(arrayOrder.get(position).getAddress_receive());
            mobile_receive.setText(arrayOrder.get(position).getName_received());
            name_receive.setText(arrayOrder.get(position).getPhone_received());
            total_money.setText(arrayOrder.get(position).getTotal_money() + " VNĐ");

            final int vitri = position;

            btn_see_map.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Intent intent = new Intent( getActivity(), MapsActivity.class);
                    intent.putExtra("destination_address", arrayOrder.get(vitri).getAddress_receive());
                    startActivity(intent);

                }
            });

            Log.w("Order", "Order getStatus_order: " + arrayOrder.get(vitri).getStatus_order());

            if (arrayOrder.get(vitri).getStatus_order().equals("3")) {
                btn_done.setText("Chuyển hàng");
            }
//            else if (arrayOrder.get(vitri).getStatus_order().equals("4")) {
//                btn_done.setText("Xong");
//            }

            btn_done.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
//                    if (arrayOrder.get(vitri).getStatus_order().equals("4")) {
//                        Login_Token.update_check = false;
//                    }
                    Log.w("btn_done", "Pickup " + Login_Token.update_check);
                    if(Login_Token.id_order!=null){
                        Login_Token.update_check = true;
                    }

                    if(Login_Token.update_check==false) {
                        //Toast.makeText(Order_Received_Activity.this, "Ok: btn_done" , Toast.LENGTH_SHORT).show();
                        if (arrayOrder.get(vitri).getStatus_order().equals("3")) {
                            Login_Token.update_check = true;
                            Login_Token.id_order = arrayOrder.get(vitri).getId_order();
                        }

                        RequestBody requestBody = new MultipartBody.Builder()
                                .setType(MultipartBody.FORM)
                                .addFormDataPart("id_order", arrayOrder.get(vitri).getId_order())
                                .addFormDataPart("status_order_rq", arrayOrder.get(vitri).getStatus_order())
                                .build();

                        Request request = new Request.Builder()
                                //.url("http://192.168.0.132:8000/api/shipper/showOrderReceived")
                                .url("https://luxexpress.cf/api/shipper/updateStatus")
                                .post(requestBody)
                                //.addHeader("name_your_token", "your_token")
                                .addHeader("Authorization", "Bearer " + token)
                                .build();

                        client.newCall(request).enqueue(new Callback() {
                            @Override
                            public void onFailure(Call call, IOException e) {
                                e.printStackTrace();
                            }

                            @Override
                            public void onResponse(Call call, Response response) throws IOException {
                                final String yourResponse = response.body().string();

                                if (response.isSuccessful()) {

                                    getActivity().runOnUiThread(new Runnable() {
                                        @Override
                                        public void run() {
                                            JSONObject Jobject = null;
                                            try {

                                                Jobject = new JSONObject(yourResponse);

                                                Log.w("btn_done", "Order received: " + yourResponse.toString());

                                                getActivity().finish();
                                                startActivity( getActivity().getIntent());


                                            } catch (JSONException e) {
                                                e.printStackTrace();
                                            }

                                        }
                                    });
                                } else {
                                    Log.w("myApp", "Order received: " + yourResponse.toString());
                                }


                            }
                        });
                    }else{
                        Toast.makeText(getActivity(), "Bạn cần giao hàng trước.", Toast.LENGTH_SHORT).show();
                    }

                }
            });

            return convertView;
        }
    }

    private class Order_Received {

        private String address_receive;
        private String address_delivery;
        private String time;
        private String id_order;
        private String status_order;
        private String billOfLading;
        private String total_money;
        private String name_received;
        private String phone_received;

        Order_Received(String address_receive, String address_delivery, String time, String idOrder, String idOrderStatus, String billOfLading, String total_money, String name_received, String phone_received) {
            this.address_receive = address_receive;
            this.address_delivery = address_delivery;
            this.time = time;
            this.id_order = idOrder;
            this.status_order = idOrderStatus;
            this.billOfLading = billOfLading;
            this.total_money = total_money;
            this.name_received = name_received;
            this.phone_received = phone_received;
        }

        public String getAddress_receive() {
            return address_receive;
        }

        public void setAddress_receive(String address_receive) {
            this.address_receive = address_receive;
        }

        public String getAddress_delivery() {
            return address_delivery;
        }

        public void setAddress_delivery(String address_delivery) {
            this.address_delivery = address_delivery;
        }

        public String getTime() {
            return time;
        }

        public void setTime(String time) {
            this.time = time;
        }

        public String getId_order() {
            return id_order;
        }

        public void setId_order(String id_order) {
            this.id_order = id_order;
        }

        public String getStatus_order() {
            return status_order;
        }

        public void setStatus_order(String status_order) {
            this.status_order = status_order;
        }

        public String getBillOfLading() {
            return billOfLading;
        }

        public void setBillOfLading(String billOfLading) {
            this.billOfLading = billOfLading;
        }

        public String getTotal_money() {
            return total_money;
        }

        public void setTotal_money(String total_money) {
            this.total_money = total_money;
        }

        public String getName_received() {
            return name_received;
        }

        public void setName_received(String name_received) {
            this.name_received = name_received;
        }

        public String getPhone_received() {
            return phone_received;
        }

        public void setPhone_received(String phone_received) {
            this.phone_received = phone_received;
        }
    }
}
