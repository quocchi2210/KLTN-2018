package com.example.quocchi.shipper_app;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

public class Order_Received_Activity extends AppCompatActivity {

    private ArrayList<Order_Received> data = new ArrayList<Order_Received>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_received);

        ListView list_view_order_received = findViewById(R.id.list_view_order_received);
//
        data.add(new Order_Received("math","123","09:00:00"));
        data.add(new Order_Received("history","456","09:00:00"));
        data.add(new Order_Received("van hoc","789","09:00:00"));
//
        list_view_order_received.setAdapter(new Order_Received_Adapter(this, R.layout.list_item_order_received, data));

    }

    private class Order_Received_Adapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order_Received> arrayOrder;

        public Order_Received_Adapter(Context context, int layout, List<Order_Received> orderList){
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

            TextView txt_address_delivery = (TextView) convertView.findViewById(R.id.txt_address_delivery);
            TextView txt_address_receive = (TextView) convertView.findViewById(R.id.txt_address_receive);
            TextView txt_time = (TextView) convertView.findViewById(R.id.txt_time);

            txt_address_delivery.setText(data.get(position).getAddress_delivery());
            txt_address_receive.setText(data.get(position).getAddress_receive());
            txt_time.setText(data.get(position).getTime());

            final int vitri = position;

            return convertView;
        }
    }

    private class Order_Received{

        private String address_receive;
        private String address_delivery;
        private String time;

        Order_Received(String address_receive, String address_delivery, String time) {
            this.address_receive = address_receive;
            this.address_delivery = address_delivery;
            this.time = time;
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
    }
}
