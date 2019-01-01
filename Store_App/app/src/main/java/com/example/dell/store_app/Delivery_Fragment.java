package com.example.dell.store_app;

import android.content.Context;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;

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

public class Delivery_Fragment extends Fragment {
    private String hostname = "luxexpress.cf";
    private OrderAdapter test;
    private String token = Login_Token.token;

    private View mRootView;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.fragment_confirm, container, false);
        final ListView lv = (ListView) mRootView.findViewById(R.id.list_view);

        CertificatePinner certificatePinner = new CertificatePinner.Builder()
                .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
                .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
                .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
                .build();

        OkHttpClient client = new OkHttpClient.Builder()
                .certificatePinner(certificatePinner)
                .build();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/store/showOrder_delivery")
                //.url(" http://192.168.0.132:8000/api/shipper/showOrder")
                .post(requestBody)
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
                    if (getActivity() != null) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                //Toast.makeText(getActivity(),"any mesage",Toast.LENGTH_LONG).show();
                                JSONObject Jobject = null;
                                try {
                                    //ListView lv = findViewById(R.id.list_view);
                                    Jobject = new JSONObject(yourResponse);

                                    JSONArray Jarray = Jobject.getJSONArray("data");

                                    ArrayList<Order> data = new ArrayList<Order>();

                                    for (int i = 0; i < Jarray.length(); i++) {
                                        JSONObject object = Jarray.getJSONObject(i);
                                        Log.w("myApp", object.toString());
                                        String billOfLading = object.getString("billOfLading");
                                        String address = object.getString("addressReceiver");
                                        String idOrder = object.getString("idOrder");
                                        String idOrderStatus = object.getString("idOrderStatus");
                                        String name_received = object.getString("nameReceiver");
                                        String phone_received = object.getString("phoneReceiver");
                                        String total_money = object.getString("totalMoney");

                                        data.add(new Order(billOfLading, address, idOrder, idOrderStatus, name_received, phone_received, total_money));
                                    }

                                    test = new OrderAdapter(getActivity(), R.layout.list_item, data);

                                    lv.setAdapter(test);
                                    Log.w("Order: ", yourResponse.toString());

                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }

                            }

                        });
                    }
                } else {

                    Log.w("error order", yourResponse.toString());
                }


            }
        });


        return mRootView;
    }

    private class OrderAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order> arrayOrder;

        public OrderAdapter(Context context, int layout, List<Order> orderList) {
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
            Log.w("myApp", "Detail: " + arrayOrder.toString());
            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);
            TextView mobile_receive = (TextView) convertView.findViewById(R.id.mobile_receive);
            TextView name_receive = (TextView) convertView.findViewById(R.id.name_receive);
            TextView total_money = (TextView) convertView.findViewById(R.id.total_money);

            Button btn_pick_up = (Button) convertView.findViewById(R.id.btn_pick_up);

            bill_of_lading.setText("Order " + arrayOrder.get(position).getBill_of_lading());
            address.setText(arrayOrder.get(position).getAddress());
            mobile_receive.setText(arrayOrder.get(position).getName_received());
            name_receive.setText(arrayOrder.get(position).getPhone_received());
            total_money.setText(arrayOrder.get(position).getTotal_money() + " VNĐ");

            //total_money.setText();

            final String id_order = arrayOrder.get(position).getId_order();

            //LinearLayout lnlo_order = (LinearLayout) convertView.findViewById(R.id.lnlo_order);

            final View Testview = convertView;

            final int vitri = position;

            return convertView;
        }
    }

    private class Order {
        private String bill_of_lading;
        private String address;
        private String id_order;
        private String id_order_status;
        private String name_received;
        private String phone_received;
        private String total_money;

        Order(String bill_of_lading, String address, String id_order, String id_order_status, String name_received, String phone_received, String total_money) {
            this.bill_of_lading = bill_of_lading;
            this.address = address;
            this.id_order = id_order;
            this.id_order_status = id_order_status;
            this.name_received = name_received;
            this.phone_received = phone_received;
            this.total_money = total_money;
        }

        public String getBill_of_lading() {
            return bill_of_lading;
        }

        public void setBill_of_lading(String bill_of_lading) {
            this.bill_of_lading = bill_of_lading;
        }

        public String getAddress() {
            return address;
        }

        public void setAddress(String address) {
            this.address = address;
        }

        public String getId_order() {
            return id_order;
        }

        public void setId_order(String id_order) {
            this.id_order = id_order;
        }


        public String getId_order_status() {
            return id_order_status;
        }

        public void setId_order_status(String id_order_status) {
            this.id_order_status = id_order_status;
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

        public String getTotal_money() {
            return total_money;
        }

        public void setTotal_money(String total_money) {
            this.total_money = total_money;
        }

    }
}
