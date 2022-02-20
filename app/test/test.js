let prices = [7,1,5,3,6,4]

prices.push('d')

console.log(prices);

// let maxProfit = 0;
// let lowestBuyPrice = prices[0]; // first day stock price

// for (let i = 0; i < prices.length - 1; i++) {
//   let sellPrice = prices[i + 1];
//   let buyPrice = prices[i];
//   let profit = sellPrice - buyPrice;

//   if (profit > 0) {
//     if (buyPrice < lowestBuyPrice) {
//       lowestBuyPrice = buyPrice;
//     }
//     if ((sellPrice - lowestBuyPrice) > maxProfit) {
//       maxProfit = sellPrice - lowestBuyPrice;
//     }
//   }
// }

// console.log(maxProfit);
